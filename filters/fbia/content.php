<?php
/**
Facebook Instant Article Content
**/
function klicked_facebook_instant_article_content($content) {
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
    add_filter($content, 'klicked_facebook_instant_article_oembed');

    // Setup preg_replace for correct formatting
    $find = array(
        // Fix empty tags and such
        '/<br.*?>/', // find <br> and replace with <p>
        '/<p.*?>/', // remove classes from <p>
        '/(<p.*?>|<p.*?>\n)(<script.*?\/>|<script.*?>.*?<\/script>)(\n<\/p>|<\/p>)/', // remove <p> from <script>
        '/(<p.*?><script.*?(video.foxnews|video.insider.foxnews|video.foxbusiness).*?id=|<script.*?(video.foxnews|video.insider.foxnews|video.foxbusiness).*?id=)(.*?)(&.*?<\/p>)/', // find Fox News embed
        '/(<p.*?>\n.*?<img.*?src="|<p.*?>.*?<img.*?src=")(.*?)(".*?<\/p>|".*?\n<\/p>)/', // find and fix <img>
        '/(<p.*?>)(<figure.*?figure>)(<\/p>)/', // find and fix <p> around <figure>
        '/(<p.*?>)(<iframe.*?iframe>)(<\/p>)/', // find and fix <iframe>
        '/(<p>)(.*?)(<iframe.*?iframe>)(.*?)(<\/p>)/', // find and fix <iframe> inside <p> with content
        '/<p><\/p>/', // find empty <p> and remove
        '/\&/', // find & and replace with HTML entity
    );
    $replace = array(
        // Fix empty tags and such
        '</p><p>', // find <br> and replace with <p>
        '<p>', // remove classes from <p>
        '$2', // remove <p> from <script>
        '<figure class="op-interactive"><iframe src="https://$2.com/v/video-embed.html?video_id=$3" width="466" height="263" marginwidth="0" marginheight="0" frameborder="0" scrolling="no"></iframe></figure>', // find Fox News embed
        '<figure><img src="$2" /></figure>', // find and fix <img>
        '$2', // find and fix <p> around <figure>
        '<figure class="op-interactive">$2</figure>', // find and fix <iframe>
        '<p>$2</p><figure class="op-interactive">$3</figure><p>$4</p>', // find and fix <iframe> inside <p> with content
        '', // find empty <p> and remove
        '&amp;', // find & and replace with HTML entity
    );

    // Run preg_replace for correct formatting
    $content = preg_replace($find, $replace, $content);

    if(klicked_mobile_api_check() == 1) {
        // Return the filtered content
        return $content;
    } else {
        // Return error message
        return 'ERROR: You are not authorized to use this plugin.';
    }
}
add_filter('klicked_fbia_content', 'klicked_facebook_instant_article_content');

/**
oEmbed Filter
**/
function klicked_facebook_instant_article_oembed($html, $url, $attr, $post_id) {

    // If doing Instant Article content filter
    if(doing_filter('klicked_fbia_content')) {
        // If YouTube or Vimeo
        if(strpos($html, 'youtu') !== false || strpos($html, 'vimeo') !== false) {
            return '<figure class="op-interactive">' . $html . '</figure>';
        } else {
            return '<figure class="op-interactive"><iframe>' . $html . '</iframe></figure>';
        }
    } else {
        return $html;
    }

}
add_filter('embed_oembed_html', 'klicked_facebook_instant_article_oembed', 10, 4);
