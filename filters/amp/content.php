<?php
/**
AMP Content
**/
function klicked_accelerated_mobile_pages_content($content) {
    // Remove &nbsp;
    $content = str_replace('&nbsp;', '', $content);
    
    // Encode HTML entities
    $content = html_entity_decode($content);
    
    // Remove shortcodes
    $content = strip_shortcodes($content);
    
    // Strip unallowed tags
    $content = strip_tags($content, '<a><caption><cite><script><h1><h2><blockquote><iframe><img><ol><ul><p><li><b><em><share><u>');
    
    // Auto-wrap paragraphs
    $content = wpautop($content, true);
    
    // OEmbed Content
    $content = $GLOBALS['wp_embed']->autoembed($content);
    
    // Filter non-iFrame oEmbeds
    add_filter($content, 'klicked_accelerated_mobile_pages_oembed');
    
    // Setup preg_replace for correct formatting
    $find = array(
        // Fix empty tags and such
        '/<br.*?>/', // find <br> and replace with <p>
        '/<p.*?>/', // remove classes from <p>
        '/(<p.*?>|<p.*?>\n)(<script.*?\/>|<script.*?>.*?<\/script>)(\n<\/p>|<\/p>)/', // remove <p> from <script>
        '/(<img.*?src=")(.*?)(".*?width=")(.*?)(".*?height=")(.*?)(".*?>)/', // fix img tag
        '/(<script.*?(video.foxnews|video.insider.foxnews|video.foxbusiness).*?id=|<script.*?(video.foxnews|video.insider.foxnews|video.foxbusiness).*?id=)(.*?)(\&.*?w=|w=)(.*?)(\&.*?h=|h=)(.*?)(".*?<\/script>)/', // fix Fox News embed
        '/(<iframe.*?width=")(.*?)(".*?height=")(.*?)(".*?src=".*?youtu.*?\/embed\/)(.*?)(\?.*?".*?><\/iframe>|".*?><\/iframe>)/', // fix YouTube iframe embed with width before src
        '/(<iframe.*?src=")(.*?youtu.*?\/embed\/)(.*?)(".*?width=")(.*?)(".*?height=")(.*?)(".*?<\/iframe>)/', // fix YouTube iframe embed with src before width
        '/(<iframe.*?src=")(.*?vimeo.*?)(".*?width=")(.*?)(".*?height=")(.*?)(".*?<\/iframe>)/', // fix Vimeo iframe
        '/<p><\/p>/', // find empty <p> and remove
        '/\&/', // find & and replace with HTML entity
    );
    $replace = array(
        // Fix empty tags and such
        '</p><p>', // find <br> and replace with <p>
        '<p>', // remove classes from <p>
        '$2', // remove <p> from <script>
        '<amp-img src="$2" width="$4" height="$6" layout="responsive"></amp-img>', // fix img tag
        '<amp-iframe width="$6" height="$8" sandbox="allow-scripts allow-same-origin" layout="responsive" src="https://$2.com/v/video-embed.html?video_id=$4"></amp-iframe>', // fix Fox News embed
        '<amp-youtube data-videoid="$6" layout="responsive" width="$2" height="$4"></amp-youtube>', // fix YouTube iframe embed with width before src
        '<amp-youtube data-videoid="$3" layout="responsive" width="$5" height="$7"></amp-youtube>', // fix YouTube iframe embed with src before width
        '<amp-iframe width="$4" height="$6" sandbox="allow-scripts allow-same-origin" layout="responsive" src="$2"></amp-iframe>', // fix Vimeo iframe
        '', // find empty <p> and remove
        '&amp;', // find & and replace with HTML entity
    );
    
    // Run preg_replace for correct formatting
    $content = preg_replace($find, $replace, $content);
    
    // Get options
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    
    // Check if ads are enabled
    if(!empty($ampopts['amp_enable_ads'])) {
        // Create locations and get ads
        $location = array();
        $fours = 0;
        $ads = array();
        $available = array('1', '2', '3', '4');
        foreach($available as $avail) {
            if(!empty($ampopts['amp_ad_'.$avail])) {
                $location[] .= $fours + 4;
                // Get ads
                $ads[] .= $ampopts['amp_ad_'.$avail.'_type'].'|'.$ampopts['amp_ad_'.$avail];
            }
            $fours += 4;
        }
        
        // Setup Variables
        $content = explode('<p>', $content);
        $total = count($content);
        $blockquote = 0;
        $adsinline = 0;

        // Look for Blockquotes & Create/Update Locations
        for ($i = 0; $i < $total; $i++) {
          if(isset($location[0])) {if($i == $location[0] && $blockquote > 0) { $location[0]++; }}
          if(isset($location[1])) {if($i == $location[1] && $blockquote > 0) { $location[1]++; }}
          if(isset($location[2])) {if($i == $location[2] && $blockquote > 0) { $location[2]++; }}
          if(isset($location[3])) {if($i == $location[3] && $blockquote > 0) { $location[3]++; }}
          // Keep track of blockquotes opening and closing
          $blockquote += substr_count( $content[$i], "<blockquote" );
          $blockquote -= substr_count( $content[$i], "</blockquote" );
          // Double check new locations aren't the same or one right after another
          if(isset($location[0]) && isset($location[1])) {if($location[0] == $location[1] || $location[0] + 1 == $location[1]) { $location[1]++; }}
          if(isset($location[1]) && isset($location[2])) {if($location[1] == $location[2] || $location[1] + 1 == $location[2]) { $location[2]++; }}
          if(isset($location[2]) && isset($location[3])) {if($location[2] == $location[3] || $location[2] + 1 == $location[3]) { $location[3]++; }}
        }

        // Content
        $output = '';

        // Check for Output Locations & Output
        for ($i = 0; $i < $total; $i++) {
          // Output Locations
          if(isset($location[0])) {if($i == $location[0] && $total > $location[0]) { $output .= klicked_mobile_amp_ads($ads[0]); $adsinline++; }}
          if(isset($location[1])) {if($i == $location[1] && $total > $location[1]) { $output .= klicked_mobile_amp_ads($ads[1]); $adsinline++; }}
          if(isset($location[2])) {if($i == $location[2] && $total > $location[2]) { $output .= klicked_mobile_amp_ads($ads[2]); $adsinline++; }}
          if(isset($location[3])) {if($i == $location[3] && $total > $location[3]) { $output .= klicked_mobile_amp_ads($ads[3]); $adsinline++; }}
          $output .= '<p>' . $content[$i];
        }
        
        // Check for ads after
        if(isset($location[2]) && $adsinline == 3 && $total > $location[2]) { $output .= klicked_mobile_amp_ads($ads[3]); }
        elseif(isset($location[1]) && $adsinline == 2 && $total > $location[1]) { $output .= klicked_mobile_amp_ads($ads[2]); }
        elseif(isset($location[0]) && $adsinline == 1 && $total > $location[0]) { $output .= klicked_mobile_amp_ads($ads[1]); }
    } else {
        $output = $content;
    }
    
    // Return the filtered content
    return $output;
}
add_filter('klicked_amp_content', 'klicked_accelerated_mobile_pages_content');

/**
oEmbed Filter
**/
function klicked_accelerated_mobile_pages_oembed($html, $url, $attr, $post_id) {
    
    // If doing AMP content filter
    if(doing_filter('klicked_amp_content')) {
        // If YouTube or Vimeo
        if(strpos($html, 'youtu') !== false) {
            // Find video ID
            $find = '/(.*?youtu.*?watch.*?v=)(.*)/';
            $replace = '$2';
            $videoid = preg_replace($find, $replace, $url);
            // Return fixed
            return '<amp-youtube data-videoid="'.$videoid.'" layout="responsive" width="560" height="315"></amp-youtube>';
        // If Facebook
        } elseif(strpos($html, 'facebook') !== false) {
            // If Facebook Post
            if(strpos($url, 'posts') !== false) {
                // Return formatted
                return '<amp-facebook width="400" height="400" layout="responsive" data-href="'.$url.'"></amp-facebook>';
            // If Facebook Video
            } elseif(strpos($html, 'videos') !== false) {
                // Find and replace
                return '<amp-facebook width="400" height="200" layout="responsive" data-embed-as="video" data-href="'.$url.'"></amp-facebook>';
            // If undetermined, treat as post
            } else {
                
            }
        // If Instagram
        } elseif(strpos($html, 'instagram') !== false) {
            // Find ID
            $find = '/(http.*?instagram.*?\/p\/)(.*?)(\/.*)/';
            $replace = '$2';
            $id = preg_replace($find, $replace, $url);
            // Return fixed
            return '<amp-instagram data-shortcode="'.$id.'" width="320" height="392" layout="responsive"></amp-instagram>';
        // If Twitter
        } elseif(strpos($html, 'twitter') !== false) { 
            // Find ID
            $find = '/(http.*?twitter.*?status\/)(.*)/';
            $replace = '$2';
            $id = preg_replace($find, $replace, $url);
            // Return fixed
            return '<amp-twitter width="500" height="600" layout="responsive" data-tweetid="'.$id.'"></amp-twitter>';
        // Other iFrame
        } else {
            // Find src
            $find = '/(<iframe.*?src=")(.*?)(".*?\/>|".*?<\/iframe>)/';
            $replace = '$2';
            $src = preg_replace($find, $replace, $html);
            // Fix src
            return '<amp-iframe width="500" height="300" sandbox="allow-scripts allow-same-origin" layout="responsive" src="'.$src.'"></amp-iframe>';
        }
    } else {
        return $html;
    }
    
}
add_filter('embed_oembed_html', 'klicked_accelerated_mobile_pages_oembed', 10, 4);