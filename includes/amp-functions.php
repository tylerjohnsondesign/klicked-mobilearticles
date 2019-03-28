<?php
/**
AMP Template Redirect
**/
function klicked_mobile_articles_amp_template() {
    global $wp_query;
    
    // Check if the query is for non-AMP version
    if(!isset($wp_query->query_vars['amp']) || !is_singular())
        return;
    
    // If intercepted query is for AMP endpoint, display template
    include KLICKEDMOB_BASE_PATH . 'templates/klicked-mobile-articles-amp.php';
    
    exit;
}
add_action('template_redirect', 'klicked_mobile_articles_amp_template');

/**
AMP Fonts
**/
function klicked_mobile_amp_fonts() {
    $font = '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,900">';
    
    // Output
    echo $font;
}

/**
AMP Link
**/
function klicked_mobile_amp_link() {
    // Check if post
    if(is_single()) {
        // Get variables
        $enabled = get_post_meta(get_the_ID(), 'klicked_amp', true);
        
        // Check if AMP is enabled
        if($enabled === 'enabled') {
            echo '<link rel="amphtml" href="'.get_permalink().'amp">';
        } else {
            // Don't do anything. AMP isn't enabled.
        }
    } else {
        // Don't do anything. This isn't a post.
    }
}
add_action('wp_head', 'klicked_mobile_amp_link', 5);

/**
AMP Styles
**/
function klicked_mobile_amp_styles() {
    // Default
    $default = '<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>';
    
    // Custom
    $custom = '
    <style amp-custom>
    body {
        font-family: "Lato", sans-serif;
        font-size: 16px;
    }
    
    body, .title h4 {
        color: #000000;
    }
    
    header {
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.05);
    }
    
    button, a {
        outline: none;
    }
    
    button.open-button {
        background: rgba(255, 255, 255, 0);
        border: none;
        float: left;
        font-size: 22px;
        font-weight: bold;
        padding: 19px;
    }

    button.close-button {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.2);
        font-weight: bold;
        font-size: 18px;
    }
    
    a {
        color: #c22a29;
    }

    amp-sidebar#sidebar {
        padding: 8px 26px;
        background: #fff;
        width: 250px;
    }

    ul#menu-mobile-menu {
        list-style: none;
        padding: 0;
    }

    ul#menu-mobile-menu li a {
        text-decoration: none;
        font-size: 16px;
        display: block;
        color: #000;
        padding: 8px 0;
    }
    
    amp-sidebar#sidebar ul {
        padding: 0;
        list-style: none;
    }

    amp-sidebar#sidebar ul li {
        text-align: center;
        margin: 10px 0;
        padding: 10px 0;
        border-bottom: 1px solid #f2f2f2;
    }

    amp-sidebar#sidebar ul li a {
        text-decoration: none;
    }

    amp-sidebar#sidebar ul li:last-child {
        border-bottom: none;
    }
    
    .branding {
        display: block;
        margin: 0 auto;
        max-width: 1000px;
        text-align: center;
        padding: 10px;
    }
    
    .branding h1 {
        margin: 0;
        height: 45px;
    }

    .branding a {
        text-decoration: none;
        color: #878787;
    }
    
    article, .copyright, .related, .subscribe {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .related-inner li {
        margin-bottom: 5px;
        padding: 20px;
        border: 1px solid #f2f2f2;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-weight: 900;
    }
    
    h1 {
        font-size: 28;
    }
    
    h2 {
        font-size: 26;
    }
    
    h3 {
        font-size: 24;
    }
    
    h4 {
        font-size: 22;
    }
    
    h5 {
        font-size: 20;
    }
    
    h6 {
        font-size: 18;
    }
    
    .title, .content, .related ul, .subscribe-inner {
        padding: 0 25px;
        margin: 20px 0;
    }
    
    .title h1 {
        font-size: 32px;
    }
    
    .title h1, .title h4, .share {
        margin: 0 0 10px 0;
    }
    
    .title h4 {
        font-weight: normal;
    }
    
    blockquote {
        margin: 20px 0px 20px 0px;
        padding-left: 20px;
        border-left: 2px solid rgba(0, 0, 0, 0.15);
    }
    
    .amp-ad-box {
        text-align: center;
    }
    
    .footer {
        background: rgba(0, 0, 0, 0.05);
        padding: 30px 0;
    }
    
    .meta, .copyright {
        font-size: 14px;
        color: rgba(0, 0, 0, 0.5);
    }
    
    .meta {
        margin: 0;
    }
    
    .subscribe-container {
        background: #f2f2f2;
        padding: 20px;
        text-align: center;
    }

    .subscribe-container h2, .subscribe-container p {
        margin: 8px 0;
    }

    a.subscribe-btn {
        display: block;
        background: #c22a29;
        color: #fff;
        text-transform: uppercase;
        text-decoration: none;
        padding: 8px 0;
        margin-top: 15px;
        margin-bottom: 5px;
    }
    
    .related ul {
        list-style: none;
    }

    .related li .image, .related-title.half-width {
        width: 100%;
    }
    
    .related li .image {
        margin-bottom: 5px;
    }

    .related li .image, .related li .related-title {
        display: inline-block;
        vertical-align: top;
    }

    .related-title.full-width {
        width: 100%;
    }

    .related-title h3 {
        margin: 0;
    }
    
    .related-title a {
        text-decoration: none;
    }
    
    div#klicked-mobile-footer-menu .menu-item {
        display: inline-block;
        margin: 5px 5px;
        font-size: 12px;
        text-align: center;
        opacity: 0.6;
    }

    div#klicked-mobile-footer-menu .menu-item a {
        text-decoration: none;
    }

    div#klicked-mobile-footer-menu ul {
        list-style: none;
        margin-top: 0;
        padding: 0 25px;
        text-align: center;
    }
    
    .copyright-text {
        padding: 0 25px;
        text-align: center;
    }
    
    .copyright a {
        text-decoration: none;
        font-weight: bold;
    }

    button#scrollToTopButton {
        position: fixed;
        bottom: 15px;
        right: 15px;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.35);
        border: none;
        border-radius: 100px;
        padding: 6px 15px;
        color: #fff;
        font-size: 25px;
        line-height: 1.2;
    }
    ';
    
    // Custom Variables
    $ampopts = get_option('mobile_articles_amp_option_name');
    
    // Menu Background
    if(!empty($ampopts['amp_menu_color'])) {
        $custom .= '
        header {
            background: '.$ampopts['amp_menu_color'].';
        }
        ';
        
        // Check color for menu button
        $hex = str_replace('#', '', $ampopts['amp_menu_color']);
        if(hexdec(substr($hex,0,2))+hexdec(substr($hex,2,2))+hexdec(substr($hex,4,2))> 382){
            // Do nothing.
        }else{
            $custom .= '
            button.open-button {
                color: #ffffff;
            }
            ';
        }
    }
    
    // Head Text Color
    if(!empty($ampopts['amp_header_color'])) {
        $custom .= '
        h1, h2, h3, h4, h5, h6 {
            color: '.$ampopts['amp_header_color'].';
        }
        ';
    }
    
    // Body Text Color
    if(!empty($ampopts['amp_body_color'])) {
        $custom .= '
        .content p, .title h4 {
            color: '.$ampopts['amp_body_color'].';
        }
        ';
    }
    
    // Accent Color
    if(!empty($ampopts['amp_accent_color'])) {
        $custom .= '
        a, a h1, a h2, a h3, a h4, a h5, a h6 {
            color: '.$ampopts['amp_accent_color'].';
        }
        
        a.subscribe-btn {
            background: '.$ampopts['amp_accent_color'].';
        }
        ';
    }
    
    // Heading Font
    if(!empty($ampopts['amp_heading_font'])) {
        
    }
    
    // Body Font
    if(!empty($ampopts['amp_body_font'])) {
        
    }
    
    $custom .= '</style>';
    
    // Output
    echo $default.$custom;
}

/**
AMP Scripts
**/
function klicked_mobile_amp_scripts() {
    // Default
    $default = '
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
    <script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
    <script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <script async custom-element="amp-sticky-ad" src="https://cdn.ampproject.org/v0/amp-sticky-ad-1.0.js"></script>
    <script async custom-element="amp-position-observer" src="https://cdn.ampproject.org/v0/amp-position-observer-0.1.js"></script>
    <script async custom-element="amp-animation" src="https://cdn.ampproject.org/v0/amp-animation-0.1.js"></script>
    ';
    
    // Output
    echo $default;
}

/**
AMP Menu
**/
// Add Menu
function klicked_mobile_amp_menu_add() {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    
    // Check
    if(!empty($ampopts['amp_enable_header_menu']) || !empty($ampopts['amp_enable_footer_menu'])) {
        $enabled = '1';
    } else {
        $enabled = '';
    }
    
    // Add Menu Location
    if(!empty($enabled)) {
        register_nav_menus(
            array(
                'amp-menu' => __('AMP Menu'),
            )
        );
    }
}
add_action('init', 'klicked_mobile_amp_menu_add');

// Output Header Menu
function klicked_mobile_amp_menu() {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    if(isset($ampopts['amp_enable_header_menu']) && !empty($ampopts['amp_enable_header_menu'])) {
        $enabled = '1';
    } else {
        $enabled = '';
    }
    
    // If enabled, output
    if(!empty($enabled)) {
        echo '<button on="tap:sidebar.toggle" class="open-button">☰</button>';
        echo '<amp-sidebar id="sidebar" layout="nodisplay"><button on="tap:sidebar.close" class="close-button">×</button>';
        wp_nav_menu(array('theme_location' => 'amp-menu'));
        echo '</amp-sidebar>';
    } else {
        // Don't do anything.
    }
}

// Output Footer Menu
function klicked_mobile_amp_footer_menu() {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    if(isset($ampopts['amp_enable_footer_menu']) && !empty($ampopts['amp_enable_footer_menu'])) {
        $enabled = '1';
    } else {
        $enabled = '';
    }
    
    // If enabled, output
    if(!empty($enabled)) {
        echo '<div id="klicked-mobile-footer-menu">';
        wp_nav_menu(array('theme_location' => 'amp-menu'));
        echo '</div>';
    } else {
        // Don't do anything.
    }
}

/**
Scroll to Top
**/
function klicked_mobile_amp_scroll_to_top() {
    // Visibility of Button
    $output = '
    <amp-animation id="showAnim"
      layout="nodisplay">
      <script type="application/json">
        {
          "duration": "200ms",
          "fill": "both",
          "iterations": "1",
          "direction": "alternate",
          "animations": [{
            "selector": "#scrollToTopButton",
            "keyframes": [{
              "opacity": "1",
              "visibility": "visible"
            }]
          }]
        }
      </script>
    </amp-animation>
    ';
    
    // Add Button
    $output .= '
    <amp-animation id="hideAnim"
      layout="nodisplay">
      <script type="application/json">
        {
          "duration": "200ms",
          "fill": "both",
          "iterations": "1",
          "direction": "alternate",
          "animations": [{
            "selector": "#scrollToTopButton",
            "keyframes": [{
              "opacity": "0",
              "visibility": "hidden"
            }]
          }]
        }
      </script>
    </amp-animation>
    ';
    
    // Start Animation on Scroll
    $output .= '
    <div id="marker">
      <amp-position-observer on="enter:hideAnim.start; exit:showAnim.start"
        layout="nodisplay">
      </amp-position-observer>
    </div>
    ';

    // Scroll Up
    $output .= '
    <button id="scrollToTopButton"
      on="tap:top-page.scrollTo(duration=200)"
      class="scrollToTop">&uarr;</button>
    ';
    
    // Output
    echo $output;
}

/**
Branding
**/
function klicked_mobile_amp_branding() {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    if(isset($ampopts['amp_logo_id']) && !empty($ampopts['amp_logo_id'])) {
        $getimage = wp_get_attachment_image_src($ampopts['amp_logo_id'], 'full');
        $height = $getimage[2];
        $width  = $getimage[1];
        $image  = $getimage[0];
    } else {
        $height = '';
        $width  = '';
        $image  = '';
    }
    
    // Math
    $difference = $height - 45;
    $percentage = round($difference/$height*100);
    $percentage = '0.'.$percentage;
    $decrease = $width * (1 - $percentage);
    
    // Put it all together
    if(!empty($image)) {
        $branding = '<div class="branding"><a href="'.get_bloginfo('url').'"><amp-img alt="'.get_bloginfo('name').'" src="'.$image.'" width="'.round($decrease).'" height="45"></amp-img></a></div>';
    } else {
        $branding = '<div class="branding"><a href="'.get_bloginfo('url').'"><h1>'.get_bloginfo('name').'</h1></a></div>';
    }
    
    // Output
    echo $branding;
}

/**
Title
**/
function klicked_mobile_amp_title($ID) {
    // Variables
    $post = get_post($ID);
    $ampopts = get_option('mobile_articles_amp_option_name');
    
    // Title
    $title = '<h1>'.get_the_title($ID).'</h1>';
    
    // Excerpt
    if(!empty($ampopts['amp_enable_excerpt'])) {
        $excerpt = '<h4>'.get_the_excerpt($ID).'</h4>';
    } else {
        $excerpt = '';
    }
    
    // Author
    $auth = $post->post_author;
    $author = '<p class="meta author">By <a href="'.get_bloginfo('url').'/author/'.urlencode(get_the_author_meta('user_login', $auth)).'">'.get_the_author_meta('display_name', $auth).'</a></p>';
    
    // Date
    $date = '<p class="meta date">'.get_the_date('F j, Y').' at '.get_the_date('g:i a').'</p>';
    
    // Output
    echo $title . $excerpt . $author . $date;
}

/**
Featured Image
**/
function klicked_mobile_amp_featured_image($ID) {
    // Get image
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $ID ), 'full' );
    
    if(empty($image)) {
        $output = '';
    } else {
        $output = '<div class="feat-image"><amp-img alt="'.get_the_title($ID).'" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" layout="responsive"></amp-img></div>';
    }
    
    // Output image
    echo $output;
}

/**
Share Buttons
**/
function klicked_mobile_amp_share() {
    $output = '
        <div class="share">
            <amp-social-share width="40" height="30" type="facebook" data-param-app_id="254325784911610"></amp-social-share>
            <amp-social-share width="40" height="30" type="twitter"></amp-social-share>
            <amp-social-share width="40" height="30" type="gplus"></amp-social-share>
            <amp-social-share width="40" height="30" type="email"></amp-social-share>
            <amp-social-share width="40" height="30" type="pinterest" data-param-media="https://ampbyexample.com/img/amp.jpg"></amp-social-share>
            <amp-social-share width="40" height="30" type="linkedin"></amp-social-share>
            <amp-social-share width="40" height="30" type="tumblr"></amp-social-share>
        </div>
    ';
    echo $output;
}

/**
AMP Ads
**/
function klicked_mobile_amp_ads($ad) {
    // Separate Ad
    $ad = explode('|', $ad);
    
    // Check for ad type
    if($ad[0] == 'adblade') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                    type="adblade"
                    data-width="'.$opts[0].'"
                    data-height="'.$opts[1].'"
                    data-cid="'.$opts[3].'">
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } elseif($ad[0] == 'adsense') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2]) && isset($opts[3])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width='.$opts[0].' height='.$opts[1].'
                    type="adsense"
                    data-ad-client="'.$opts[2].'"
                    data-ad-slot="'.$opts[3].'">
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } elseif($ad[0] == 'appnexus') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                    type="appnexus"
                    data-tagid="'.$opts[2].'">
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } elseif($ad[0] == 'doubleclick') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Check for refresh rate and rtc
        if(isset($opts[3]) && $opts[3] != 0) {
            $refresh = 'data-enable-refresh="'.$opts[3].'"';
        } else {
            $refresh = '';
        }
        if(isset($opts[4])) {
            $rtc = 'rtc-config=\''.$opts[4].'\'';
        } else {
            $rtc = '';
        }
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width='.$opts[0].' height='.$opts[1].'
                    type="doubleclick"
                    data-slot="'.$opts[2].'"
                    '.$refresh.'
                    '.$rtc.'>
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } elseif($ad[0] == 'kixer') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                    type="kixer"
                    data-adslot="'.$opts[2].'">
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } elseif($ad[0] == 'revcontent') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2]) && isset($opts[3]) && isset($opts[4])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width="'.$opts[0].'" height="'.$opts[1].'" layout="responsive" 
                      type="revcontent"
                      heights="'.$opts[2].'"
                      data-wrapper="'.$opts[3].'"
                      data-id="'.$opts[4].'">
                  <div placeholder="">Loading ...</div>
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } elseif($ad[0] == 'yandex') {
        // Variables
        $opts = explode(',', $ad[1]);
        
        // Compose
        if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
            $output = '
            <div class="amp-ad-box">
                <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                    type="yandex"
                    data-block-id="'.$opts[2].'">
                </amp-ad>
            </div>
            ';
        } else {
            $output = '';
        }
    } else {
        $output = '';
    }
    
    // Return
    return $output;
}

/**
Sticky AMP Ad
**/
function klicked_mobile_sticky_amp_ad() {
    // Get options
    $ampopts = get_option('mobile_articles_amp_option_name');
    
    // Checks
    if(!empty($ampopts['amp_enable_ads']) && !empty($ampopts['amp_ad_5'])) {
        // Get ad options
        $ad = $ampopts['amp_ad_5_type'].'|'.$ampopts['amp_ad_5'];
        $ad = explode('|', $ad);
    
        // Check for ad type
        if($ad[0] == 'adblade') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
                $output = '
                <amp-sticky-ad>
                    <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                        type="adblade"
                        data-width="'.$opts[0].'"
                        data-height="'.$opts[1].'"
                        data-cid="'.$opts[2].'">
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } elseif($ad[0] == 'adsense') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2]) && isset($opts[3])) {
                $output = '
                <amp-sticky-ad layout="nodisplay">
                    <amp-ad width='.$opts[0].' height='.$opts[1].'
                        type="adsense"
                        data-ad-client="'.$opts[2].'"
                        data-ad-slot="'.$opts[3].'">
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } elseif($ad[0] == 'appnexus') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
                $output = '
                <amp-sticky-ad layout="nodisplay">
                    <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                        type="appnexus"
                        data-tagid="'.$opts[2].'">
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } elseif($ad[0] == 'doubleclick') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
                $output = '
                <amp-sticky-ad layout="nodisplay">
                    <amp-ad width='.$opts[0].' height='.$opts[1].'
                        type="doubleclick"
                        data-slot="'.$opts[2].'">
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } elseif($ad[0] == 'kixer') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
                $output = '
                <amp-sticky-ad layout="nodisplay">
                    <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                        type="kixer"
                        data-adslot="'.$opts[2].'">
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } elseif($ad[0] == 'revcontent') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2]) && isset($opts[3]) && isset($opts[4])) {
                $output = '
                <amp-sticky-ad layout="nodisplay">
                    <amp-ad width="'.$opts[0].'" height="'.$opts[1].'" layout="responsive" 
                          type="revcontent"
                          heights="'.$opts[2].'"
                          data-wrapper="'.$opts[3].'"
                          data-id="'.$opts[4].'">
                      <div placeholder="">Loading ...</div>
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } elseif($ad[0] == 'yandex') {
            // Variables
            $opts = explode(',', $ad[1]);

            // Compose
            if(isset($opts[0]) && isset($opts[1]) && isset($opts[2])) {
                $output = '
                <amp-sticky-ad layout="nodisplay">
                    <amp-ad width="'.$opts[0].'" height="'.$opts[1].'"
                        type="yandex"
                        data-block-id="'.$opts[2].'">
                    </amp-ad>
                </amp-sticky-ad>
                ';
            } else {
                $output = '';
            }
        } else {
            $output = '';
        }
    } else {
        $output = 'Not working';
    }
    
    // Return
    echo $output;
}

/**
Subscribe
**/
function klicked_mobile_amp_subscribe() {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    
    // Checks
    if(isset($ampopts['amp_enable_subscribe']) && !empty($ampopts['amp_enable_subscribe'])) {
        $enabled = '1';
    } else {
        $enabled = '';
    }
    $suburl = $ampopts['amp_subscribe_link'];
    if(!empty($ampopts['amp_subscribe_title'])) {
        $subtitle = $ampopts['amp_subscribe_title'];
    } else {
        $subtitle = 'Subscribe to '.get_bloginfo('name');
    }
    if(!empty($ampopts['amp_subscribe_text'])) {
        $subtext = $ampopts['amp_subscribe_text'];
    } else {
        $subtext = 'Get more stories like this in your inbox!';
    }
    if(!empty($ampopts['amp_subscribe_button'])) {
        $subbtn = $ampopts['amp_subscribe_button'];
    } else {
        $subbtn = 'Subscribe';
    }
    
    // Compose
    $output = '<div class="subscribe"><div class="subscribe-inner"><div class="subscribe-container">';
    $output .= '<h2>'.$subtitle.'</h2>';
    $output .= '<p>'.$subtext.'</p>';
    $output .= '<a href="'.$suburl.'" class="subscribe-btn" target="_blank">'.$subbtn.'</a>';
    $output .= '</div></div></div>';
    
    // Output
    if(!empty($enabled) && !empty($suburl)) {
        echo $output;
    }
}

/**
Related
**/
function klicked_mobile_amp_related($id) {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    
    // Checks
    if(!empty($ampopts['amp_enable_related'])) {
        $enabled = '1';
    } else {
        $enabled = '';
    }
    
    
    if(!empty($enabled)) {
        // Variables
        $cat = get_the_category($id);
        
        // Args
        $args = array(
            'post_type'         => array('post'),
            'post_status'       => array('publish'),
            'posts_per_page'   => '5',
            //'cat'               => $cat,
            'post__not_in'       => array($id),
        );
        
        // Run
        $related = new WP_Query($args);
        
        // Loop
        if($related->have_posts()) {
            $output = '<div class="related"><ul><div class="related-inner"><h2 class="related-section">'.get_bloginfo('name').' Recommends</h2>';
            while($related->have_posts()) {
                $related->the_post();
                
                // Variables
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full' );

                if(empty($image)) {
                    $image = '';
                    $class = ' full-width';
                } else {
                    $image = '<div class="image"><a href="'.get_permalink().'"><amp-img alt="'.get_the_title().'" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" layout="responsive"></amp-img></a></div>';
                    $class = ' half-width';
                }
                
                // Output
                $output .= '<li>'.$image.'<div class="related-title'.$class.'"><a href="'.get_permalink().'"><h3>'.get_the_title().'</h3></a></div></li>';
            }
            $output .= '</div></ul></div>';
        } else {
            $output = 'No related posts.';
        }
        
        // Reset postdata
        wp_reset_postdata();
    } else {
        $output = '';
    }
    
    // Output related
    echo $output;
}

/**
Analytics
**/
function klicked_mobile_amp_analytics() {
    // Compose
    $output = '
        <amp-analytics type="googleanalytics" id="analytics1">
            <script type="application/json">
            {
                "vars": {
                    "account": "UA-XXXX-Y"
                },
                "triggers": {
                    "trackPageview": {
                        "on": "visibile",
                        "request": "pageview"
                    }
                }
            }
            </script>
        </amp-analytics>
        <amp-analytics type="parsely">
        <script type="application/json">
            {
                "vars": {
                    "apikey": "'.preg_replace('/https:\/\/|http:\/\/|www\.|\//', '', get_bloginfo('url')).'"
                }
            }
        </script>
        </amp-analytics>
    ';
    
    // Output
    echo $output;
}