<?php
/**
Verify Facebook Page
**/
function klicked_mobile_facebook_verify() {
    // Get variables
    $fbia_options = get_option( 'mobile_articles_fbia_option_name' );
    $pageid = $fbia_options['fbia_access_token'];
    
    // Output
    if(!empty($pageid)) {
        $output = '<meta property="fb:pages" content="'.$pageid.'" />';
    } else {
        $output = '';
    }
    echo $output;
}
add_action('wp_head', 'klicked_mobile_facebook_verify', 20);

/**
Compose Instant Article
**/
function klicked_mobile_fbia_publish($ID) {
    // Get variables
    $fbia_options = get_option( 'mobile_articles_fbia_option_name' );
    $fbia_able = $fbia_options['fbia_enable'];
    $enableads = $fbia_options['fbia_enable_ads'];
    $ad1 = $fbia_options['fbia_ad_placement_1'];
    $ad2 = $fbia_options['fbia_ad_placement_2'];
    $ad3 = $fbia_options['fbia_ad_placement_3'];
    $ad4 = $fbia_options['fbia_ad_placement_4'];
    $ad5 = $fbia_options['fbia_ad_placement_5'];
    $analytics = $fbia_options['fbia_enable_analytics'];
    $analyticsgroup = $fbia_options['fbia_enable_analytics_group'];
    $analyticsid = $fbia_options['fbia_analytics_id'];
    $additional = $fbia_options['fbia_additional_analytics'];
    $fbiastyle  = $fbia_options['fbia_custom_style'];
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'full' );
    $pageid = $fbia_options['fbia_access_token'];
    $pagetoken = $fbia_options['fbia_page_token'];
    $videocover = get_post_meta($ID, 'klicked_mobile_fbia_cover_url', true);
    
    // Create ad array
    $fbads = array();
    if(!empty($ad1)) {
        $fbads[] .= $ad1;
    }
    if(!empty($ad2)) {
        $fbads[] .= $ad2;
    }
    if(!empty($ad3)) {
        $fbads[] .= $ad3;
    }
    if(!empty($ad4)) {
        $fbads[] .= $ad4;
    }
    
    if(!empty($enableads) && !empty($fbads)) {
        $adtemplate = '<meta property="fb:use_automatic_ad_placement" content="true" ad_density="default">';
        $advertisements = '<section class="op-ad-template">';
        $count = 0;
        foreach($fbads as $fbad) {
            $count++;
            if($count == 1) {
                $default = ' op-ad-default';
            } else {
                $default = '';
            }
            $advertisements .= '<figure class="op-ad'.$default.'"><iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement='.$fbad.'&adtype=banner300x250"></iframe></figure>';
        }
        $advertisements .= '</section>';
    } else {
        $advertisements = '';
        $adtemplate = '';
    }
    
    // Set up variables
    if(!empty($ad5)) {
        $recirculation_ad = '<meta property="fb:op-recirculation-ads" content="placement_id='.$ad5.'">';
    } else {
        $recirculation_ad = '';
    }
    
    if(!empty(get_the_excerpt($ID))) {
        $excerpt = '<h3 class="op-kicker">'.htmlentities(get_the_excerpt($ID)).'</h3>';
    } else {
        $excerpt = '';
    }
    
    // Cover
    if(!empty($videocover)) {
        $cover = '<figure><video><source src="'.$videocover.'" type="video/mp4" /></video></figure>';
    } elseif(!empty($image[0])) {
        $cover = '<figure><img src="'.$image[0].'" /></figure>';
    } else {
        $cover = '';
    }
    
    // Custom Style Check
    if(empty($fbiastyle)) {
        $fbiastyle = 'Default';
    } else {
        $fbiastyle = $fbiastyle;
    }
    
    // Get content
    $post = get_post($ID);
    $content = $post->post_content;
    $content = apply_filters('klicked_fbia_content', $content); 
    
    // Get Author
    $auth = $post->post_author;
    $author = get_the_author_meta('display_name', $auth);
    
    // Permalink
    if(empty(get_post_meta($ID, 'klicked_stored_url', true))) {
		$permalink = get_permalink($ID);
	} else {
        $permapost = get_post($ID);
        $permaslug = $permapost->post_name;
		$permalink = get_post_meta($ID, 'klicked_stored_url', true).'/'.$permaslug;
	}
    
    // Get style
    
    // Get pieces
    $head = '<head><meta charset="utf-8"><link rel="canonical" href="'.$permalink.'">'.$adtemplate.$recirculation_ad.'<title>'.htmlentities(get_the_title($ID)).'</title><meta propert="fb:article_style" content="'.$fbiastyle.'"></head>';
    
    $header = '<header>'.$cover.'<h1>'.htmlentities(get_the_title($ID)).'</h1>'.$excerpt.'<address><a>'.$author.'</a></address><time class="op-published" datetime="'.get_the_date('Y-m-d', $ID).'T'.get_the_date('G:i:s+00:00', $ID).'">'.get_the_date('M j, Y, g:i a', $ID).'</time><time class="op-modified" datetime="'.get_the_modified_date('Y-m-d', $ID).'T'.get_the_date('G:i:s+00:00').'">'.get_the_modified_date('M j, Y, g:i a', $ID).'</time>'.$advertisements.'</header>';
    
    // Tracking
    if(!empty($analytics) && !empty($analyticsid) || !empty($additional)) {
        // Opening
        $tracking = '<figure class="op-tracker"><iframe>';
        
        // Google Analytics
        if(!empty($analytics) && !empty($analyticsid)) {
            $tracking .= '
            <script async="async" src="https://www.googletagmanager.com/gtag/js?id='.$analyticsid.'"></script>
            <script>
                // Get share URL and replace
                var shareURL = ia_document.shareURL;
                var srcURL = shareURL.replace(/(http.*?\?)(.*utm_source=)((.*?)(\&.*)|(.*))/g, \'$4\');
                
                // Check replaces
                if(srcURL == \'undefined\' || srcURL == \'null\' || srcURL == \'\') {
                    fixsrcURL = shareURL.replace(/(http.*?\?)(.*utm_source=)((.*?)(\&.*)|(.*))/g, \'$6\');
                } else {
                    fixsrcURL = srcURL;
                }
            
                // GTAG
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments)};
                gtag(\'js\', new Date());

                gtag(\'create\', \''.$analyticsid.'\', \'auto\');
                gtag(\'set\', \'page_title\', \'FBIA: \'+ia_document.title);

                // Output GA
                if(fixsrcURL !== \'undefined\' && fixsrcURL !== \'null\' && fixsrcURL !== \'\' && fixsrcURL.indexOf(\'http\') !== 0) {
                    gtag(\'set\', \'campaignSource\', fixsrcURL);
                }
                
                gtag(\'send\', \'pageview\');

                gtag(\'config\', \''.$analyticsid.'\'';
            // Content Grouping
            if(!empty($analyticsgroup)) {
                $tracking .= ', {\'content_group1\': \'Instant Articles\'});';
            } else {
                $tracking .= ');';
            }
            $tracking .= '</script>';
        }
        
        // Additional
        if(!empty($additional)) {
            $tracking .= html_entity_decode($additional);
        }
        
        // Closing
        $tracking .= '</iframe></figure>';
    }
    
    $footer = '<footer><small>Copyright &copy; '.date('Y').' '.get_bloginfo('name').'. All Rights Reserved.</small></footer>';
    
    // Compose article
    $article = '<!doctype html><html lang="en" prefix="op: http://media.facebook.com/op#">'.$head.'<body><article>'.$header.$content.$tracking.$footer.'</article></body></html>';
    
    // Post article via cURL
    $ch = curl_init();
    
    // Options
    if(empty($fbia_able)) {
        // cURL Options
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v3.0/'.$pageid.'/instant_articles');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'access_token'      => $pagetoken,
            'html_source'       => $article,
            'published'         => 'false',
            'development_mode'  => 'false',
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    } else {
        // cURL Options
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v3.0/'.$pageid.'/instant_articles');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'access_token'      => $pagetoken,
            'html_source'       => $article,
            'published'         => 'true',
            'development_mode'  => 'false',
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    }

    // Run
    $responses = curl_exec($ch);
    $response = json_decode($responses, true);

    // Close
    curl_close($ch);
    
    // Store Instant Article ID
    if(!empty($response['id'])) {
        update_post_meta($ID, 'klicked_fbia_import_id', $response['id']);
        update_post_meta($ID, 'klicked_fbia_errors', null);
    } else {
        update_post_meta($ID, 'klicked_fbia_errors', $responses);
    }
}

/**
Check Instant Article Status
**/
function klicked_mobile_fbia_status_check() {
    // Variables
    $fbia_options = get_option( 'mobile_articles_fbia_option_name' );
    $pagetoken = $fbia_options['fbia_page_token'];
    $fbimportid = get_post_meta($_POST['post_id'], 'klicked_fbia_import_id', true);
    
    // Check for AJAX
    if(defined('DOING_AJAX') && DOING_AJAX && !empty($fbimportid)) {
        // Check status
        $result = file_get_contents('https://graph.facebook.com/v3.0/'.$fbimportid.'?access_token='.$pagetoken.'&fields=status,errors,instant_article');
        
        // Decode JSON
        $result = json_decode($result, true);
        
        // Encode JSON Errors
        if(!empty($result['errors'])) {
            $errors = json_encode($result['errors']);
        } else {
            $errors = null;
        }
        
        // Store status
        update_post_meta($_POST['post_id'], 'klicked_fbia_status', $result['status']);
        update_post_meta($_POST['post_id'], 'klicked_fbia_errors', $errors);
        
        if(empty($result['status']) || $result['status'] == 'FAILED') {
            echo 'Error.';
        } else {
            echo $result['status'];
            update_post_meta($_POST['post_id'], 'klicked_fbia_id', $result['instant_article']['id']);
        }
    }
}
add_action('wp_ajax_klicked_mobile_fbia_status_check', 'klicked_mobile_fbia_status_check');

/**
Delete Instant Article
**/
function klicked_mobile_fbia_delete($ID) {
    // Variables
    $fbia_options = get_option( 'mobile_articles_fbia_option_name' );
    $pagetoken = $fbia_options['fbia_page_token'];
    $fbia_id = get_post_meta($ID, 'klicked_fbia_id', true);
    
    // Post article via cURL
    $ch = curl_init();

    // cURL Options
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v3.0/'.$fbia_id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        'access_token'      => $pagetoken,
    )));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Run
    $responses = curl_exec($ch);
    $response = json_decode($responses, true);

    // Close
    curl_close($ch);
    
    // Store Instant Article ID
    if($response['success'] == 'true') {
        update_post_meta($ID, 'klicked_fbia_errors', null);
        update_post_meta($ID, 'klicked_fbia_id', null);
        update_post_meta($ID, 'klicked_fbia_status', null);
        update_post_meta($ID, 'klicked_fbia_import_id', null);
    } else {
        update_post_meta($ID, 'klicked_fbia_errors', $responses);
    }
}

/**
Compose RSS Feed Instant Article
**/
function klicked_mobile_articles_rss_feed_article($ID) {
    // Variables
    $fbia_options = get_option( 'mobile_articles_fbia_option_name' );
    if(!empty($fbia_options['fbia_enable_ads'])) {
        $enableads = $fbia_options['fbia_enable_ads'];
    } else {
        $enableads = '';
    }
    $ad1 = $fbia_options['fbia_ad_placement_1'];
    $ad2 = $fbia_options['fbia_ad_placement_2'];
    $ad3 = $fbia_options['fbia_ad_placement_3'];
    $ad4 = $fbia_options['fbia_ad_placement_4'];
    $ad5 = $fbia_options['fbia_ad_placement_5'];
    $fbiastyle  = $fbia_options['fbia_custom_style'];
    if(!empty($fbia_options['fbia_enable_analytics'])) {
        $analytics = $fbia_options['fbia_enable_analytics'];
    } else {
        $analytics = '';
    }
    if(!empty($fbia_options['fbia_enable_analytics_group'])) {
        $analyticsgroup = $fbia_options['fbia_enable_analytics_group'];
    } else {
        $analyticsgroup = '';
    }
    $analyticsid = $fbia_options['fbia_analytics_id'];
    $additional = $fbia_options['fbia_additional_analytics'];
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'full' );
    $videocover = get_post_meta($ID, 'klicked_mobile_fbia_cover_url', true);

    // Create Ad Array
    $fbads = array();
    // Compile
    if(!empty($ad1)) {
        $fbads[] = $ad1;
    }
    if(!empty($ad2)) {
        $fbads[] = $ad2;
    }
    if(!empty($ad3)) {
        $fbads[] = $ad3;
    }
    if(!empty($ad4)) {
        $fbads[] = $ad4;
    }
    
    // Create Ads
    if(!empty($enableads) && !empty($fbads)) {
        $adtemplate = '<meta property="fb:use_automatic_ad_placement" content="true" ad_density="default">';
        $advertisements = '<section class="op-ad-template">';
        $count = 0;
        foreach($fbads as $fbad) {
            $count++;
            if($count == 1) {
                $default = ' op-ad-default';
            } else {
                $default = '';
            }
            $advertisements .= '<figure class="op-ad'.$default.'"><iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement='.$fbad.'&adtype=banner300x250"></iframe></figure>';
        }
        $advertisements .= '</section>';
    } else {
        $advertisements = '';
        $adtemplate = '';
    }
    
    // Set up variables
    if(!empty($ad5)) {
        $recirculation_ad = '<meta property="fb:op-recirculation-ads" content="placement_id='.$ad5.'">';
    } else {
        $recirculation_ad = '';
    }
    
    if(!empty(get_the_excerpt($ID))) {
        $excerpt = '<h3 class="op-kicker">'.preg_replace('/&#?[a-z0-9]{2,8};/i', '', get_the_excerpt($ID)).'</h3>';
    } else {
        $excerpt = '';
    }
    
    // Cover
    if(!empty($videocover) && strpos($videocover, 'mp4') !== false) {
        $cover = '<figure><video><source src="'.$videocover.'" type="video/mp4" /></video></figure>';
    } elseif(!empty($image[0])) {
        $cover = '<figure><img src="'.$image[0].'" /></figure>';
    } else {
        $cover = '';
    }
    
    // Custom Style Check
    if(empty($fbiastyle)) {
        $fbiastyle = 'Default';
    } else {
        $fbiastyle = $fbiastyle;
    }
    
    // Get content
    $post = get_post($ID);
    $content = $post->post_content;
    $content = apply_filters('klicked_fbia_content', $content); 
    
    // Get Author
    $auth = $post->post_author;
    $author = get_the_author_meta('display_name', $auth);
    
    // Permalink
    if(empty(get_post_meta($ID, 'klicked_stored_url', true))) {
		$permalink = get_permalink($ID);
	} else {
        $permapost = get_post($ID);
        $permaslug = $permapost->post_name;
		$permalink = get_post_meta($ID, 'klicked_stored_url', true).'/'.$permaslug;
	}
    
    // Get pieces
    $head = '<head><meta charset="utf-8"><link rel="canonical" href="'.$permalink.'">'.$adtemplate.$recirculation_ad.'<title>'.htmlentities(get_the_title($ID)).'</title><meta propert="fb:article_style" content="'.$fbiastyle.'"></head>';
    
    $header = '<header>'.$cover.'<h1>'.htmlentities(get_the_title($ID)).'</h1>'.$excerpt.'<address><a>'.$author.'</a></address><time class="op-published" datetime="'.get_the_date('Y-m-d', $ID).'T'.get_the_date('G:i:s+00:00', $ID).'">'.get_the_date('M j, Y, g:i a', $ID).'</time><time class="op-modified" datetime="'.get_the_modified_date('Y-m-d', $ID).'T'.get_the_date('G:i:s+00:00').'">'.get_the_modified_date('M j, Y, g:i a', $ID).'</time>'.$advertisements.'</header>';
    
    // Tracking
    if(!empty($analytics) && !empty($analyticsid) || !empty($additional)) {
        // Opening
        $tracking = '<figure class="op-tracker"><iframe>';
        
        // Google Analytics
        if(!empty($analytics) && !empty($analyticsid)) {
            $tracking .= '
            <script async="async" src="https://www.googletagmanager.com/gtag/js?id='.$analyticsid.'"></script>
            <script>
                // Get share URL and replace
                var shareURL = ia_document.shareURL;
                var srcURL = shareURL.replace(/(http.*?\?)(.*utm_source=)((.*?)(\&.*)|(.*))/g, \'$4\');
                
                // Check replaces
                if(srcURL == \'undefined\' || srcURL == \'null\' || srcURL == \'\') {
                    fixsrcURL = shareURL.replace(/(http.*?\?)(.*utm_source=)((.*?)(\&.*)|(.*))/g, \'$6\');
                } else {
                    fixsrcURL = srcURL;
                }
            
                // GTAG
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments)};
                gtag(\'js\', new Date());

                gtag(\'create\', \''.$analyticsid.'\', \'auto\');
                gtag(\'set\', \'page_title\', \'FBIA: \'+ia_document.title);

                // Output GA
                if(fixsrcURL !== \'undefined\' && fixsrcURL !== \'null\' && fixsrcURL !== \'\' && fixsrcURL.indexOf(\'http\') !== 0) {
                    gtag(\'set\', \'campaignSource\', fixsrcURL);
                }
                
                gtag(\'send\', \'pageview\');

                gtag(\'config\', \''.$analyticsid.'\'';
            // Content Grouping
            if(!empty($analyticsgroup)) {
                $tracking .= ', {\'content_group1\': \'Instant Articles\'});';
            } else {
                $tracking .= ');';
            }
            $tracking .= '</script>';
        }
        
        // Additional
        if(!empty($additional)) {
            $tracking .= html_entity_decode($additional);
        }
        
        // Closing
        $tracking .= '</iframe></figure>';
    } else {
        $tracking = '';
    }
    
    $footer = '<footer><small>Copyright &copy; '.date('Y').' '.get_bloginfo('name').'. All Rights Reserved.</small></footer>';
    
    // Compose article
    $article = '<![CDATA[<!doctype html><html lang="en" prefix="op: http://media.facebook.com/op#">'.$head.'<body><article>'.$header.$content.$tracking.$footer.'</article></body></html>]]>';
    
    // RSS Item
    $item = '<item>';
    $item .= '<title>'.preg_replace('/&#?[a-z0-9]{2,8};/i', '', get_the_title($ID)).'</title>';
    $item .= '<link>'.$permalink.'</link>';
    $item .= '<guid>'.wp_get_shortlink().'</guid>';
    $item .= '<pubDate>'.get_the_date('Y-m-d') . 'T' . get_the_date('G:i:s+00:00').'</pubDate>';
    $item .= '<author>'.get_the_author().'</author>';
    $item .= '<description>'.$excerpt.'</description>';
    $item .= '<content:encoded>'.$article.'</content:encoded>';
    $item .= '</item>';
    
    // Send Item
    echo $item;
}