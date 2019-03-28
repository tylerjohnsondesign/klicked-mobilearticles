/**
Facebook Connection
**/
jQuery(document).ready(function() {
    // Hide sections
    jQuery('span#fbia-setup').parent('h2').next('table.form-table').addClass('klicked-fbia-setup');
    jQuery('span#fbia-settings').parent('h2').next('table.form-table').addClass('klicked-fbia-settings');
    jQuery('span#fbia-setup').parent('h2').next('table.form-table').hide();
    jQuery('span#fbia-settings').parent('h2').next('table.form-table').hide();
    jQuery('span#fbia-settings').parent('h2').hide();
    jQuery('.klicked-mobile-fbia form > p.submit').hide();
    
    // Variables
    var clientID = jQuery('input#fbia_client_id').val();
    var clientSecret = jQuery('input#fbia_client_secret').val();
    var pageAccess = jQuery('input#fbia_access_token').val();
    var pageToken = jQuery('input#fbia_page_token').val();
    
    // Field checks
    if(clientID === '' || clientSecret === '') {
        // Show client ID and client secret fields
        jQuery('input#fbia_client_id').show();
        jQuery('input#fbia_client_secret').show();
        jQuery('div#klicked_fbia_step_1').show();
        jQuery('span#fbia-setup').parent('h2').next('table.form-table').show();
    } else if(pageAccess === '' || pageToken === '') {
        // Show Continue with Facebook button
        jQuery('div#klicked_fbia_step_2').show();
        jQuery('span#fbia-setup').parent('h2').next('table.form-table').show();
    } else {
        // Add clear button
        jQuery('span#fbia-setup').parent('h2').after('<div id="klicked_fbia_clear"><button class="klicked-fbia-clear"><span>×</span> Disconnect Facebook</button></div>');
        
        // If clear button clicked
        jQuery('#klicked_fbia_clear button').on('click', function() {
            // Clear fields and save
            jQuery('input#fbia_access_token').val('');
            jQuery('input#fbia_page_token').val('');
        });
        
        // Display settings section
        jQuery('span#fbia-settings').parent('h2').next('table.form-table').show();
        jQuery('span#fbia-settings').parent('h2').show();
        jQuery('.klicked-mobile-fbia form > p.submit').show();
    }
    
    // Continue with Facebook click
    jQuery('#klicked_fbia_step_2 button').on('click', function() {
        // Log user in and get required permissions
        FB.login(function(response) {
            // If successful connection
            if(response.status === 'connected') {
                // Get short lived access token
                var shortToken = response.authResponse.accessToken;
                
                // Remove button
                jQuery('#klicked_fbia_step_2 button').hide();
                
                // Get long lived acces token
                jQuery.get('https://graph.facebook.com/v3.0/oauth/access_token?grant_type=fb_exchange_token&client_id='+clientID+'&client_secret='+clientSecret+'&fb_exchange_token='+shortToken, function(data) {
                    // Variables
                    var longToken = data.access_token;
                    
                    // Get Facebook pages using long token
                    jQuery.get('https://graph.facebook.com/me/accounts?access_token='+longToken+'&pretty=1&limit=1000', function(data) {
                        // Get data
                        var pages = data;
                        
                        // Parse pagesArray
                        jQuery.each(pages, function(key, value) {
                            // Parse each page information
                            jQuery.each(value, function(key, value) {
                                if(value.id === undefined || value.id === '') {
                                    // Do nothing.
                                } else {
                                    jQuery('#klicked_fbia_pages ul').append('<li class="klicked-fbia-pages" data-id="'+value.id+'" data-token="'+value.access_token+'"><span>'+value.name+'</span></li>');
                                }
                            });
                        });
                        
                        // Check for page selection and fill fields
                        jQuery('li.klicked-fbia-pages').on('click', function() {
                            // Add and remove classes
                            jQuery('li.klicked-fbia-pages').removeClass('selected');
                            jQuery(this).addClass('selected');
                            
                            // Grab values
                            var pageID = jQuery(this).data('id');
                            var pageToken = jQuery(this).data('token');
                            
                            // Add values to fields
                            jQuery('input#fbia_page_token').val(pageToken);
                            jQuery('input#fbia_access_token').val(pageID);
                            
                            // Display final submit button
                            jQuery('div#klicked_fbia_step_3').show();
                        });
                    });
                });
                console.log(response.authResponse);
            }
        }, {scope:'pages_manage_instant_articles,pages_show_list',return_scopes:true});
    });
});

/**
AMP Color Pickers
**/
// Color Pickers
jQuery(document).ready(function() {
    jQuery('.klicked-amp-colors').wpColorPicker();
});

/**
AMP Ads
**/
jQuery(document).ready(function($) {
    // Run on each
    $('.klicked-amp-ad-type').each(function() {
        // Variables
        var curVal = $(this).val();
        var newChild = $(this).data('child');
        
        // Checks
        if(curVal == 'adblade') {
            var newPlace = 'width,height,clientID';
        } else if(curVal == 'adsense') {
            var newPlace = 'width,height,clientID,slotID';
        } else if(curVal == 'appnexus') {
            var newPlace = 'width,height,tagID';
        } else if(curVal == 'doubleclick') {
            var newPlace = 'width,height,slot,refresh,rtc';
        } else if(curVal == 'kixer') {
            var newPlace = 'width,height,slot';
        } else if(curVal == 'revcontent') {
            var newPlace = 'width,height,heights,wrapper,ID';
        } else {
            var newPlace = 'width,height,blockID';
        }
        
        // Output
        $('#'+newChild).prop('placeholder', newPlace);
    });
    
    // On change
    $('.klicked-amp-ad-type').on('change', function() {
        // Variables
        var curVal = $(this).val();
        var newChild = $(this).data('child');
        
        // Checks
        if(curVal == 'adblade') {
            var newPlace = 'width,height,clientID';
        } else if(curVal == 'adsense') {
            var newPlace = 'width,height,clientID,slotID';
        } else if(curVal == 'appnexus') {
            var newPlace = 'width,height,tagID';
        } else if(curVal == 'doubleclick') {
            var newPlace = 'width,height,slot,refresh,rtc';
        } else if(curVal == 'kixer') {
            var newPlace = 'width,height,slot';
        } else if(curVal == 'revcontent') {
            var newPlace = 'width,height,heights,wrapper,ID';
        } else {
            var newPlace = 'width,height,blockID';
        }
        
        // Output
        $('#'+newChild).val('');
        $('#'+newChild).prop('placeholder', newPlace);
    });
});

/**
AMP Logo
**/
// Logo Upload
jQuery(document).ready(function($){
    var custom_uploader
    , click_elem = jQuery('.klicked-amp-logo-btn')
    , target = jQuery('input#amp_logo')

    click_elem.click(function(e) {
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            target.val(attachment.url);
            jQuery('div#klicked-amp-logo-img').html('<img src="'+attachment.url+'" />');
            jQuery('#amp_logo_id').val(attachment.id);
        });
        //Open the uploader dialog
        custom_uploader.open();
    });      
});

// Image Uploader display
var baseImage = jQuery('input#amp_logo').val();
jQuery('div#klicked-amp-logo-img').html('<img src="'+baseImage+'" />');

/**
iOS Switches
**/
/* Switches.js */
!function(e){e.fn.extend({iosCheckbox:function(){"true"!==e(this).attr("data-ios-checkbox")&&(e(this).attr("data-ios-checkbox","true"),e(this).each(function(){var c=e(this),s=jQuery("<div>",{"class":"ios-ui-select"}).append(jQuery("<div>",{"class":"inner"}));c.is(":checked")&&s.addClass("checked"),c.hide().after(s),s.click(function(){s.toggleClass("checked"),s.hasClass("checked")?c.prop("checked",!0):c.prop("checked",!1)})}))}})}(jQuery);

// Add iOS class
jQuery(document).ready(function() {
    jQuery('.wrap.klicked-mobile-wrap.klicked-mobile-fbia input[type=checkbox]').addClass('ios');
});

// Activate switches
jQuery(document).ready(function() {
    jQuery('.ios').iosCheckbox();
});