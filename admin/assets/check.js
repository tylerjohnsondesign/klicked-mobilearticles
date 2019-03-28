jQuery(document).ready(function() {
    var postStatus = jQuery('.klicked_mobile_status').data('status');
    
    // If post status is pending
    if(postStatus === 'pending') {
        // Disable uncheck
        jQuery('p.klicked-fbia-meta-cont .ios-ui-select.checked').off('click');
        jQuery('p.klicked-fbia-meta-cont .ios-ui-select.checked').on('click', function() {
            jQuery('.klicked-message-box').addClass('active');
            jQuery('.klicked-message-box').addClass('message');
            jQuery('.klicked-message-box span').html('<strong>Note:</strong> Still importing data. Please refresh the page before trying to delete. Thank you.');
        });
        
        // Get post ID
        var postID = jQuery('.klicked_mobile_status').data('postid');
        
        // Check on load
        jQuery.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'klicked_mobile_fbia_status_check',
                post_id: postID,
            },
            success: function(response) {
                if(response === 'SUCCESS0') {
                    jQuery('.klicked_mobile_status').removeClass('klicked_mobile_status_pending');
                    jQuery('.klicked_mobile_status').addClass('klicked_mobile_status_published');
                    jQuery('span.klicked_mobile_status_tooltip').text('Published');
                    jQuery('span.klicked_mobile_status_check').hide();
                } else {
                    // Do nothing.
                }
            }
        });
    }
    
    // Check on button click
    jQuery('span.klicked_mobile_status_check span').on('click', function() {
        jQuery('input#publish').click();
    });
    
});