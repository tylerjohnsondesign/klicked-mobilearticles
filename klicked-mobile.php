<?php
/*
Plugin Name: Mobile Articles by Klicked Media
Plugin URI: https://klicked.com
Description: Take advantage of Facebook's Instant Articles and Google's Accelerated Mobile Pages.
Version: 2.0.9
Author: Tyler Johnson
Author URI: http://tylerjohnsondesign.com/
Copyright: Tyler Johnson
Text Domain: klickedmobile
Copyright © 2017 WP Developers. All Rights Reserved.
*/

/*--------------------------------------------------
NOTE: Software and code is only usable by Klicked Media, Patriot Ad Network, Bravera, or Romulus websites only. All other sites outside of the network are unauthorizd and will incur a fine if used. And yeah, we track requests and usage, so we know.
--------------------------------------------------*/

/**
Disallow Direct Access to Plugin File
**/
if(!defined('WPINC')) { die; }

/**
Constants
**/
define('KLICKEDMOB_BASE_VERSION', '2.0.9');
define('KLICKEDMOB_BASE_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('KLICKEDMOB_BASE_URI', trailingslashit(plugin_dir_url(__FILE__)));
define('KLICKEDMOB_API_URI', base64_decode('aHR0cHM6Ly9rbGlja2VkLmNvbS93cC1qc29uL2FjY2Vzcy92Mi9tb2JpbGUtYXJ0aWNsZXM='));

/**
Updates
**/
require KLICKEDMOB_BASE_PATH.'updates/plugin-update-checker.php';
$KlickedMobUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/klickedmedia/klicked-mobile',
    __FILE__,
    'klicked-mobile'
);
// Authentication token
$KlickedMobUpdateChecker->setAuthentication('049e3a5256f906850ffa5cb9c60ddc3696b85e75');
// Set stable branch
$KlickedMobUpdateChecker->setBranch('master');

/**
Includes
**/
// Base Functions
require_once(KLICKEDMOB_BASE_PATH . 'includes/functions.php');
// FBIA Functions
require_once(KLICKEDMOB_BASE_PATH . 'includes/fbia-functions.php');
// AMP Functions
require_once(KLICKEDMOB_BASE_PATH . 'includes/amp-functions.php');
// Admin
require_once(KLICKEDMOB_BASE_PATH . 'admin/settings.php');

/**
Filters
**/
// For Instant Articles
require_once(KLICKEDMOB_BASE_PATH . 'filters/fbia/content.php');
// For AMP
require_once(KLICKEDMOB_BASE_PATH . 'filters/amp/content.php');

/**
On Initialization
**/
function klicked_mobile_articles__initiate() {
    // Add Instant Articles Feed
    add_feed('instant', 'klicked_mobile_articles_feed_template');

    // Add AMP Endpoint
    add_rewrite_endpoint( 'amp', EP_PERMALINK | EP_PAGES );
}
add_action('init', 'klicked_mobile_articles__initiate');

/**
RSS Feed Template
**/
function klicked_mobile_articles_feed_template() {
    include(KLICKEDMOB_BASE_PATH.'rss/feed.php');
}

/**
On Activation
**/
function klicked_mobile_articles__activate() {
    // Trigger Feed Creation
    klicked_mobile_articles__initiate();

    // Trigger Permalink Flush
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'klicked_mobile_articles__activate');

/**
On Deactivation
**/
function klicked_mobile_articles__deactivate() {
    // Delete transient
    delete_transient('klicked_mobile_api');
    // Trigger permalink flush
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'klicked_mobile_articles__deactivate');

/**
API Check
**/
function klicked_mobile_api_check() {
    // Get transient
    $api = get_transient('klicked_mobile_api');

    // If empty, get value and set
    if(empty($api) || $api == 0) {
        $urls = file_get_contents(KLICKEDMOB_API_URI);
        $urls = json_decode($urls, true);
        $test = $urls[get_bloginfo('url')];

        // If $test == 1, store in transient
        if($test == 1) {
            $check = 1;
            set_transient('klicked_mobile_api', $check, 60*60*12);
        } else {
            $check = 0;
            set_transient('klicked_mobile_api', $check, 60*60*12);
            klicked_mobile_notification();
        }
    } else {
        $check = $api;
    }

    // Output check results
    return $check;
}
