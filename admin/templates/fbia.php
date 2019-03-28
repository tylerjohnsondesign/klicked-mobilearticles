<?php
// Get variables
$fbia_options = get_option( 'mobile_articles_fbia_option_name' );
$fbia_appid = $fbia_options['fbia_client_id'];

// Check for app ID
if(!empty($fbia_appid)) { ?>
<!-- Facebook SDK -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=<?php echo $fbia_appid; ?>';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>

<!-- Page Wrap -->
<div class="wrap klicked-mobile-wrap klicked-mobile-fbia">
    <!-- Header -->
    <img src="<?php echo KLICKEDMOB_BASE_URI . 'admin/assets/klicked-mobile-fbia.png'; ?>" alt="Facebook Instant Articles by Klicked Media"/>
    <?php settings_errors(); ?>
    <!-- Fields -->
    <form method="post" action="options.php">
        <?php
            settings_fields( 'mobile_articles_fbia_option_group' );
            do_settings_sections( 'mobile-articles-fbia-admin' );
            submit_button();
        ?>
    </form>
    <!-- Copyright -->
    <div class="klicked-mobile-copyright">&copy; <?php echo date('Y'); ?> <a href="//klicked.com" target="_blank">Klicked Media</a>. All Rights Reserved.</div>
</div>