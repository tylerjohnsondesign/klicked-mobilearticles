<?php
// Get Query
global $wp_query;

// Get post
$post = get_post(get_the_ID());

// Get the content
$getcontent = get_post_field('post_content', $post->ID);
$content = apply_filters('klicked_amp_content', $getcontent);

// Get excerpt
$excerpts = get_the_excerpt();
if(empty($excerpts)) {
    $excerpt = wp_trim_words($content, 55, null);
} else {
    $excerpt = $excerpts;
}

// Get author
$auth = $post->post_author;
$author = get_the_author_meta('display_name', $auth);

// Get options
$ampopts = get_option('mobile_articles_amp_option_name');
?>
<!doctype html>
<html amp lang="en">
    <!-- Head -->
    <head>
        <meta charset="utf-8">
        <title><?php echo get_the_title(); ?></title>
        <link rel="canonical" href="<?php echo get_permalink(); ?>">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
        <!-- Fonts -->
        <?php klicked_mobile_amp_fonts(); ?>
        <!-- /Fonts -->
        <!-- Styles -->
        <?php klicked_mobile_amp_styles(); ?>
        <!-- /Styles -->
        <!-- Scripts -->
        <?php klicked_mobile_amp_scripts(); ?>
        <!-- Scripts -->
        <!-- Schema -->
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "NewsArticle",
                "mainEntityOfPage": "<?php echo get_permalink(); ?>",
                "headline": "<?php echo get_the_title(); ?>",
                "datePublished": "<?php echo get_the_date('c'); ?>",
                "dateModified": "<?php echo get_the_modified_date('c'); ?>",
                "description": "<?php echo $excerpt; ?>",
                "author": {
                    "@type": "Person",
                    "name": "<?php echo $author; ?>"
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "<?php echo get_bloginfo('name'); ?>",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "http://cdn.ampproject.org/logo.jpg",
                        "width": 600,
                        "height": 60
                    }
                },
                "image": {
                    "@type": "ImageObject",
                    "url": "http://cdn.ampproject.org/leader.jpg",
                    "height": 2000,
                    "width": 800
                }
            }
        </script>
        <!-- /Schema -->
    </head>
    <!-- /Head -->
    <!-- Body -->
    <body>
        <!-- Top of Page -->
        <div id="top-page"></div>
        <?php klicked_mobile_amp_scroll_to_top(); ?>
        <!-- /Top of Page -->
        <!-- Menu -->
        <?php klicked_mobile_amp_menu(); ?>
        <!-- /Menu -->
        <!-- Sticky Ad -->
        <?php klicked_mobile_sticky_amp_ad(); ?>
        <!-- /Sticky Ad -->
        <!-- Header -->
        <header>
            <?php klicked_mobile_amp_branding(); ?>
        </header>
        <!-- /Header -->
        <!-- Article -->
        <article>
            <!-- Title Section -->
            <div class="title">
                <?php klicked_mobile_amp_title(get_the_ID()); ?>
            </div>
            <!-- /Title Section -->
            <!-- Featured Image -->
            <div class="featured-image">
                <?php klicked_mobile_amp_featured_image(get_the_ID()); ?>
            </div>
            <!-- /Featured Image -->
            <!-- Content -->
            <div class="content">
                <?php klicked_mobile_amp_share(); ?>
                <?php echo $content; ?>
            </div>
            <!-- /Content -->
        </article>
        <!-- /Article -->
        <!-- Subscribe -->
        <?php klicked_mobile_amp_subscribe(); ?>
        <!-- /Subscribe -->
        <!-- Related -->
        <?php klicked_mobile_amp_related(get_the_ID()); ?>
        <!-- /Related -->
        <!-- Analytics -->
        <?php klicked_mobile_amp_analytics(); ?>
        <!-- /Analytics -->
    </body>
    <!-- /Body -->
    <!-- Footer -->
    <div class="footer">
        <!-- Menu -->
        <?php klicked_mobile_amp_footer_menu(); ?>
        <!-- /Menu -->
        <!-- Copyright -->
        <div class="copyright">
            <div class="copyright-text">
                &copy; <?php echo date('Y'); ?> <a href="<?php echo get_bloginfo('url'); ?>" target="_blank"><?php echo get_bloginfo('name'); ?></a>. All Rights Reserved.
            </div>
        </div>
        <!-- /Copyright -->
    </div>
    <!-- /Footer -->
</html>