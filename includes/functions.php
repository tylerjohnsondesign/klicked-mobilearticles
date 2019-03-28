<?php
/**
On Post Publish
**/
function klicked_mobile_articles_publish_api($ID, $post) {
    // Checks
    $fbia = get_post_meta($ID, 'klicked_fbia', true);
    $import = get_post_meta($ID, 'klicked_fbia_import_id', true);
    $status = get_post_status($ID);
    
    // If Facebook Instant Articles is enabled for this post
    if($fbia == 'enabled' && klicked_mobile_api_check() == 1) {
        klicked_mobile_fbia_publish($ID);
    } elseif(empty($fbia) && !empty($import) && klicked_mobile_api_check() == 1) {
        klicked_mobile_fbia_status_check($ID);
    } else {
        // Do nothing.
    }
}
add_action('publish_post', 'klicked_mobile_articles_publish_api', 10, 2);

/**
FBIA Bad Words
**/
function klicked_mobile_fbia_words($new_status, $old_status, $post) {
    // Variables
    $fbopts = get_option( 'mobile_articles_fbia_option_name' );
    
    // Check status
    if($new_status === 'publish' && isset($fbopts['fbia_enable_filter'])) {
        // Check for FBIA
        if(!empty(get_post_meta($post->ID, 'klicked_fbia', true))) {
            // Check for Words
            $bad = array('AR-15', 'ar15', 'blood', 'bloodbath', 'cancer', 'dead', 'death', 'die', 'graphic', 'gun', 'gunman', 'guns', 'handgun', 'kill', 'killed', 'killer', 'killing', 'massacre', 'murder', 'murderer', 'rape', 'raped', 'rapist', 'sex', 'sexually', 'sexuality', 'sexy', 'shooter', 'shooting', 'suicide');
            $content = $post->post_content;
            $matches = array();
            $found = preg_match_all(
                '/\b('.implode($bad,'|').')\b/i',
                $content,
                $matches
            );
            
            // If bad words are found
            if($found) {
                // Create a list of the words and compile the error message
                $words = array_unique($matches[0]);
                $total = count($words);
                $count = 0;
                
                // Create the beginning of the message
                $message = 'We are sorry, but your post contains word(s) that are not allowed within Instant Articles. Usage of these word(s) can cause the post to be unpublished on Facebook and/or the site\'s Facebook page to lose access to Instant Articles. The word(s) used are: '; 
                
                // Go through the words used
                foreach($words as $word) {
                    $count++;
                    if($count === $total) {
                        $message .= ' <strong>'.$word.'</strong>.';
                    } else {
                        $message .= ' <strong>'.$word.'</strong>,';
                    }
                }
                
                // Close message
                $message .= ' Please remove these words or disable Instant Articles in order to publish. Thank you!
                <div><a href="'.get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit" style="background: #0085ba;border-color: #0073aa #006799 #006799;box-shadow: 0 1px 0 #006799;color: #fff;text-decoration: none;text-shadow: 0 -1px 1px #006799, 1px 0 1px #006799, 0 1px 1px #006799, -1px 0 1px #006799;padding: 5px 25px;border-radius: 4px;">Go Back</a></div>
                <script type="text/javascript">
                history.pushState(null, null, '.$_SERVER["REQUEST_URI"].');
                window.addEventListener(\'popstate\', function(event) {
                    window.location.assign("'.get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit");
                });
                </script>';
                
                // Compile save information for bad post
                $newpost = array(
                    'ID'            => $post->ID,
                    'post_status'   => 'draft',
                );

                // Save the bad post
                wp_update_post($newpost);
                
                // Kill publishing action
                wp_die($message);
            }
        }
    }
}
add_action('transition_post_status', 'klicked_mobile_fbia_words', 10, 3);

/**
Notification
**/
function klicked_mobile_notification() {
    // Compose
    $to = 'tyler@klicked.com';
    $subject = 'Unauthorized Use of Klicked Mobile Articles';
    $message = 'The site, '.get_bloginfo('name').', with the URL: '.get_bloginfo('url').', is using the Klicked Mobile Articles plugin without authorization.';
    
    // Send
    wp_mail($to, $subject, $message);
}