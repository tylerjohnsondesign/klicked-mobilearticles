<div class="wrap klicked-mobile-wrap klicked-mobile-amp">
    <!-- Header -->
    <img src="<?php echo KLICKEDMOB_BASE_URI . 'admin/assets/klicked-mobile-amp.png'; ?>" alt="Facebook Instant Articles by Klicked Media"/>
    <?php settings_errors(); ?>
    <!-- Fields -->
    <form method="post" action="options.php" class="klicked-amp-settings">
        <?php
            settings_fields( 'mobile_articles_amp_option_group' );
            do_settings_sections( 'mobile-articles-amp-admin' );
            submit_button();
        ?>
    </form>
    <!-- Copyright -->
    <div class="klicked-mobile-copyright">&copy; <?php echo date('Y'); ?> <a href="//klicked.com" target="_blank">Klicked Media</a>. All Rights Reserved.</div>
</div>