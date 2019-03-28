<?php
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'" ?>'; ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
<?php do_action('rss2_ns'); ?>
<channel>
    <title><?php bloginfo_rss('name'); ?></title>
    <link><?php bloginfo_rss('url'); ?></link>
    <description><?php bloginfo_rss('description'); ?></description>
    <lastBuildDate><?php echo date('Y-m-d').'T'.date('G:i:s+00:00'); ?></lastBuildDate>
    <language>en</language>
    <?php
    // Query
    $args = array(
        'post_type'             => array('post'),
        'post_status'           => array('publish'),
        'nopaging'              => false,
        'posts_per_page'        => '10',
        'ignore_sticky_posts'   => true,
        'order'                 => 'DESC',
        'orderby'               => 'date',
        'meta_query'            => array(
            array(
                'key'           => 'klicked_fbia',
                'value'         => 'enabled',
            ),
        ),
    );
    
    // Run Query
    $instant = new WP_Query($args);
    
    // Loop
    if($instant->have_posts()) {
        while($instant->have_posts()) {
            $instant->the_post();
            
            // Output Articles
            klicked_mobile_articles_rss_feed_article(get_the_ID());
        }
    }
    
    // Restore Post Data
    wp_reset_postdata(); ?>
</channel>
</rss>