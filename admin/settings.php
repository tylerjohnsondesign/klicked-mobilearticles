<?php
/**
Settings Home
**/
class MobileArticles {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mobile_articles_add_plugin_page' ) );
	}

	public function mobile_articles_add_plugin_page() {
		add_menu_page(
			'Mobile Articles', // page_title
			'Mobile Articles', // menu_title
			'manage_options', // capability
			'mobile-articles', // menu_slug
			array( $this, 'mobile_articles_create_admin_page' ), // function
            'data:image/svg+xml;base64,' . base64_encode('<svg version="1.1" id="Layer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><polygon fill-rule="evenodd" clip-rule="evenodd" fill="#a0a5aa" points="17.819,8.356 10.684,8.356 14.165,0.026 5.592,8.356 5.583,8.356 2.18,11.67 9.316,11.67 5.835,20 14.407,11.67 14.407,11.67 "/></svg>'), // icon
			81 // position
		);
	}

	public function mobile_articles_create_admin_page() {
        include KLICKEDMOB_BASE_PATH . 'admin/templates/welcome.php';
    }
}
if ( is_admin() )
	$mobile_articles = new MobileArticles();

/**
Facebook Instant Articles
**/
class MobileArticlesFBIA {
	private $mobile_articles_fbia_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mobile_articles_fbia_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'mobile_articles_fbia_page_init' ) );
	}

	public function mobile_articles_fbia_add_plugin_page() {
        add_submenu_page( 
            'mobile-articles',
            'Instant Articles',
            'Instant Articles',
            'manage_options',
            'mobile-articles-fbia',
            array( $this, 'mobile_articles_fbia_create_admin_page' )
        );
	}

	public function mobile_articles_fbia_create_admin_page() {
		$this->mobile_articles_fbia_options = get_option( 'mobile_articles_fbia_option_name' );
            include KLICKEDMOB_BASE_PATH . 'admin/templates/fbia.php';
	    }

	public function mobile_articles_fbia_page_init() {
		register_setting(
			'mobile_articles_fbia_option_group', // option_group
			'mobile_articles_fbia_option_name', // option_name
			array( $this, 'mobile_articles_fbia_sanitize' ) // sanitize_callback
		);
        
        add_settings_section(
			'mobile_articles_fbia_setup_section', // id
			'<span id="fbia-setup">Setup</span>', // title
			array( $this, 'mobile_articles_fbia_section_info' ), // callback
			'mobile-articles-fbia-admin' // page
		);
        
        add_settings_field(
			'fbia_client_id', // id
			'', // title
			array( $this, 'fbia_client_id_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setup_section' // section
		);
        
        add_settings_field(
			'fbia_client_secret', // id
			'', // title
			array( $this, 'fbia_client_secret_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setup_section' // section
		);
        
        add_settings_field(
			'fbia_access_token', // id
			'', // title
			array( $this, 'fbia_access_token_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setup_section' // section
		);
        
        add_settings_field(
			'fbia_page_token', // id
			'', // title
			array( $this, 'fbia_page_token_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setup_section' // section
		);

		add_settings_section(
			'mobile_articles_fbia_setting_section', // id
			'<span id="fbia-settings">Settings</span>', // title
			array( $this, 'mobile_articles_fbia_section_info' ), // callback
			'mobile-articles-fbia-admin' // page
		);
        
        add_settings_field(
			'fbia_enable', // id
			'', // title
			array( $this, 'fbia_enable_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_enable_all', // id
			'', // title
			array( $this, 'fbia_enable_all_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_enable_filter', // id
			'', // title
			array( $this, 'fbia_enable_filter_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_enable_ads', // id
			'', // title
			array( $this, 'fbia_enable_ads_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_ad_placement_1', // id
			'', // title
			array( $this, 'fbia_ad_placement_1_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_ad_placement_2', // id
			'', // title
			array( $this, 'fbia_ad_placement_2_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_ad_placement_3', // id
			'', // title
			array( $this, 'fbia_ad_placement_3_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_ad_placement_4', // id
			'', // title
			array( $this, 'fbia_ad_placement_4_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_ad_placement_5', // id
			'', // title
			array( $this, 'fbia_ad_placement_5_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_enable_analytics', // id
			'', // title
			array( $this, 'fbia_enable_analytics_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_enable_analytics_group', // id
			'', // title
			array( $this, 'fbia_enable_analytics_group_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_analytics_id', // id
			'', // title
			array( $this, 'fbia_analytics_id_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_additional_analytics', // id
			'', // title
			array( $this, 'fbia_additional_analytics_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
        
        add_settings_field(
			'fbia_custom_style', // id
			'', // title
			array( $this, 'fbia_custom_style_callback' ), // callback
			'mobile-articles-fbia-admin', // page
			'mobile_articles_fbia_setting_section' // section
		);
	}

	public function mobile_articles_fbia_sanitize($input) {
		$sanitary_values = array();
        if ( isset( $input['fbia_client_id'] ) ) {
			$sanitary_values['fbia_client_id'] = sanitize_text_field( $input['fbia_client_id'] );
		}
        
        if ( isset( $input['fbia_client_secret'] ) ) {
			$sanitary_values['fbia_client_secret'] = sanitize_text_field( $input['fbia_client_secret'] );
		}
        
        if ( isset( $input['fbia_access_token'] ) ) {
			$sanitary_values['fbia_access_token'] = sanitize_text_field( $input['fbia_access_token'] );
		}
        
        if ( isset( $input['fbia_page_token'] ) ) {
			$sanitary_values['fbia_page_token'] = sanitize_text_field( $input['fbia_page_token'] );
		}
        
        if ( isset( $input['fbia_enable'] ) ) {
			$sanitary_values['fbia_enable'] = $input['fbia_enable'];
		}
        
        if ( isset( $input['fbia_enable_all'] ) ) {
			$sanitary_values['fbia_enable_all'] = $input['fbia_enable_all'];
		}
        
        if ( isset( $input['fbia_enable_filter'] ) ) {
			$sanitary_values['fbia_enable_filter'] = $input['fbia_enable_filter'];
		}
        
        if ( isset( $input['fbia_enable_ads'] ) ) {
			$sanitary_values['fbia_enable_ads'] = $input['fbia_enable_ads'];
		}
        
        if ( isset( $input['fbia_ad_placement_1'] ) ) {
			$sanitary_values['fbia_ad_placement_1'] = sanitize_text_field( $input['fbia_ad_placement_1'] );
		}
        
        if ( isset( $input['fbia_ad_placement_2'] ) ) {
			$sanitary_values['fbia_ad_placement_2'] = sanitize_text_field( $input['fbia_ad_placement_2'] );
		}
        
        if ( isset( $input['fbia_ad_placement_3'] ) ) {
			$sanitary_values['fbia_ad_placement_3'] = sanitize_text_field( $input['fbia_ad_placement_3'] );
		}
        
        if ( isset( $input['fbia_ad_placement_4'] ) ) {
			$sanitary_values['fbia_ad_placement_4'] = sanitize_text_field( $input['fbia_ad_placement_4'] );
		}
        
        if ( isset( $input['fbia_ad_placement_5'] ) ) {
			$sanitary_values['fbia_ad_placement_5'] = sanitize_text_field( $input['fbia_ad_placement_5'] );
		}
        
        if ( isset( $input['fbia_enable_analytics'] ) ) {
			$sanitary_values['fbia_enable_analytics'] = $input['fbia_enable_analytics'];
		}
        
        if ( isset( $input['fbia_enable_analytics_group'] ) ) {
			$sanitary_values['fbia_enable_analytics_group'] = $input['fbia_enable_analytics_group'];
		}
        
        if ( isset( $input['fbia_analytics_id'] ) ) {
			$sanitary_values['fbia_analytics_id'] = sanitize_text_field( $input['fbia_analytics_id'] );
		}
        
        if ( isset( $input['fbia_additional_analytics'] ) ) {
			$sanitary_values['fbia_additional_analytics'] = esc_textarea( $input['fbia_additional_analytics'] );
		}
        
        if ( isset( $input['fbia_custom_style'] ) ) {
			$sanitary_values['fbia_custom_style'] = sanitize_text_field( $input['fbia_custom_style'] );
		}

		return $sanitary_values;
	}

	public function mobile_articles_fbia_section_info() {
		
	}
        
    public function fbia_client_id_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Client ID" name="mobile_articles_fbia_option_name[fbia_client_id]" id="fbia_client_id" value="%s" style="display: none;">',
			isset( $this->mobile_articles_fbia_options['fbia_client_id'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_client_id']) : ''
		);
	}
    
    public function fbia_client_secret_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Client Secret" name="mobile_articles_fbia_option_name[fbia_client_secret]" id="fbia_client_secret" value="%s" style="display: none;">
            <div id="klicked_fbia_step_1" style="display: none;">
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Continue">
                </p>
            </div>
            <div id="klicked_fbia_step_2" style="display: none;">
                <button type="button" class="klicked-continue-facebook">Continue with Facebook</button>
            </div>
            <div id="klicked_fbia_pages">
                <ul></ul>
            </div>',
			isset( $this->mobile_articles_fbia_options['fbia_client_secret'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_client_secret']) : ''
		);
	}
    
    public function fbia_access_token_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Access Token" name="mobile_articles_fbia_option_name[fbia_access_token]" id="fbia_access_token" value="%s" style="display: none;">',
			isset( $this->mobile_articles_fbia_options['fbia_access_token'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_access_token']) : ''
		);
	}
    
    public function fbia_page_token_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Page Token" name="mobile_articles_fbia_option_name[fbia_page_token]" id="fbia_page_token" value="%s" style="display: none;">
            <div id="klicked_fbia_step_3" style="display: none;">
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </div>',
			isset( $this->mobile_articles_fbia_options['fbia_page_token'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_page_token']) : ''
		);
	}
    
    public function fbia_enable_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_fbia_option_name[fbia_enable]" id="fbia_enable" value="fbia_enable" %s><span class="klicked-fbia-label">Enable Checkbox</span>',
			( isset( $this->mobile_articles_fbia_options['fbia_enable'] ) && $this->mobile_articles_fbia_options['fbia_enable'] === 'fbia_enable' ) ? 'checked' : ''
		);
	}
    
    public function fbia_enable_all_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_fbia_option_name[fbia_enable_all]" id="fbia_enable_all" value="fbia_enable_all" %s><span class="klicked-fbia-label">Enable as Default</span>',
			( isset( $this->mobile_articles_fbia_options['fbia_enable_all'] ) && $this->mobile_articles_fbia_options['fbia_enable_all'] === 'fbia_enable_all' ) ? 'checked' : ''
		);
	}
    
    public function fbia_enable_filter_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_fbia_option_name[fbia_enable_filter]" id="fbia_enable_filter" value="fbia_enable_filter" %s><span class="klicked-fbia-label">Enable Content Filter</span>',
			( isset( $this->mobile_articles_fbia_options['fbia_enable_filter'] ) && $this->mobile_articles_fbia_options['fbia_enable_filter'] === 'fbia_enable_filter' ) ? 'checked' : ''
		);
	}
    
    public function fbia_enable_ads_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_fbia_option_name[fbia_enable_ads]" id="fbia_enable_ads" value="fbia_enable_ads" %s><span class="klicked-fbia-label">Enable Ads</span>',
			( isset( $this->mobile_articles_fbia_options['fbia_enable_ads'] ) && $this->mobile_articles_fbia_options['fbia_enable_ads'] === 'fbia_enable_ads' ) ? 'checked' : ''
		);
	}
    
    public function fbia_ad_placement_1_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Placement 1" name="mobile_articles_fbia_option_name[fbia_ad_placement_1]" id="fbia_ad_placement_1" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_ad_placement_1'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_ad_placement_1']) : ''
		);
	}
    
    public function fbia_ad_placement_2_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Placement 2" name="mobile_articles_fbia_option_name[fbia_ad_placement_2]" id="fbia_ad_placement_2" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_ad_placement_2'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_ad_placement_2']) : ''
		);
	}
    
    public function fbia_ad_placement_3_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Placement 3" name="mobile_articles_fbia_option_name[fbia_ad_placement_3]" id="fbia_ad_placement_3" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_ad_placement_3'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_ad_placement_3']) : ''
		);
	}
    
    public function fbia_ad_placement_4_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Placement 4" name="mobile_articles_fbia_option_name[fbia_ad_placement_4]" id="fbia_ad_placement_4" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_ad_placement_4'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_ad_placement_4']) : ''
		);
	}
    
    public function fbia_ad_placement_5_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Placement 5" name="mobile_articles_fbia_option_name[fbia_ad_placement_5]" id="fbia_ad_placement_5" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_ad_placement_5'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_ad_placement_5']) : ''
		);
	}
    
    public function fbia_enable_analytics_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_fbia_option_name[fbia_enable_analytics]" id="fbia_enable_analytics" value="fbia_enable_analytics" %s><span class="klicked-fbia-label">Enable Analytics</span>',
			( isset( $this->mobile_articles_fbia_options['fbia_enable_analytics'] ) && $this->mobile_articles_fbia_options['fbia_enable_analytics'] === 'fbia_enable_analytics' ) ? 'checked' : ''
		);
	}
    
    public function fbia_enable_analytics_group_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_fbia_option_name[fbia_enable_analytics_group]" id="fbia_enable_analytics_group" value="fbia_enable_analytics_group" %s><span class="klicked-fbia-label">Enable Group Tracking</span>',
			( isset( $this->mobile_articles_fbia_options['fbia_enable_analytics_group'] ) && $this->mobile_articles_fbia_options['fbia_enable_analytics_group'] === 'fbia_enable_analytics_group' ) ? 'checked' : ''
		);
	}
    
    public function fbia_analytics_id_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Analytics ID" name="mobile_articles_fbia_option_name[fbia_analytics_id]" id="fbia_analytics_id" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_analytics_id'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_analytics_id']) : ''
		);
	}
    
    public function fbia_additional_analytics_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="mobile_articles_fbia_option_name[fbia_additional_analytics]" id="textarea">%s</textarea>',
			isset( $this->mobile_articles_fbia_options['fbia_additional_analytics'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_additional_analytics']) : ''
		);
	}
    
    public function fbia_custom_style_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Custom Style" name="mobile_articles_fbia_option_name[fbia_custom_style]" id="fbia_custom_style" value="%s">',
			isset( $this->mobile_articles_fbia_options['fbia_custom_style'] ) ? esc_attr( $this->mobile_articles_fbia_options['fbia_custom_style']) : ''
		);
	}

}

/**
Google Accelerated Mobile Pages
**/
class MobileArticlesAMP {
	private $mobile_articles_amp_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mobile_articles_amp_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'mobile_articles_amp_page_init' ) );
	}

	public function mobile_articles_amp_add_plugin_page() {
        add_submenu_page( 
            'mobile-articles',
            'AMP',
            'AMP',
            'manage_options',
            'mobile-articles-amp',
            array( $this, 'mobile_articles_amp_create_admin_page' )
        );
	}

	public function mobile_articles_amp_create_admin_page() {
		$this->mobile_articles_amp_options = get_option( 'mobile_articles_amp_option_name' );
        include KLICKEDMOB_BASE_PATH . 'admin/templates/amp.php';
    }

	public function mobile_articles_amp_page_init() {
		register_setting(
			'mobile_articles_amp_option_group', // option_group
			'mobile_articles_amp_option_name', // option_name
			array( $this, 'mobile_articles_amp_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'mobile_articles_amp_setting_section', // id
			'<span id="amp-settings">Settings</span>', // title
			array( $this, 'mobile_articles_amp_section_info' ), // callback
			'mobile-articles-amp-admin' // page
		);
        
        add_settings_field(
            'amp_enable_checkbox', // id
            '', // title
            array( $this, 'amp_enable_checkbox_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_all_checkbox', // id
            '', // title
            array( $this, 'amp_enable_all_checkbox_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_header_menu', // id
            '', // title
            array( $this, 'amp_enable_header_menu_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_excerpt', // id
            '', // title
            array( $this, 'amp_enable_excerpt_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_ads', // id
            '', // title
            array( $this, 'amp_enable_ads_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_subscribe', // id
            '', // title
            array( $this, 'amp_enable_subscribe_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_related', // id
            '', // title
            array( $this, 'amp_enable_related_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_enable_footer_menu', // id
            '', // title
            array( $this, 'amp_enable_footer_menu_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_logo', // id
            '', // title
            array( $this, 'amp_logo_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_logo_id', // id
            '', // title
            array( $this, 'amp_logo_id_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_subscribe_header', // id
            '', // title
            array( $this, 'amp_subscribe_header_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_subscribe_text', // id
            '', // title
            array( $this, 'amp_subscribe_text_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_subscribe_button', // id
            '', // title
            array( $this, 'amp_subscribe_button_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_subscribe_link', // id
            '', // title
            array( $this, 'amp_subscribe_link_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_menu_color', // id
            '', // title
            array( $this, 'amp_menu_color_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_header_color', // id
            '', // title
            array( $this, 'amp_header_color_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_header_font', // id
            '', // title
            array( $this, 'amp_header_font_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_body_color', // id
            '', // title
            array( $this, 'amp_body_color_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_body_font', // id
            '', // title
            array( $this, 'amp_body_font_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_accent_color', // id
            '', // title
            array( $this, 'amp_accent_color_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_1_type', // id
            '', // title
            array( $this, 'amp_ad_1_type_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_1', // id
            '', // title
            array( $this, 'amp_ad_1_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_2_type', // id
            '', // title
            array( $this, 'amp_ad_2_type_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_2', // id
            '', // title
            array( $this, 'amp_ad_2_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_3_type', // id
            '', // title
            array( $this, 'amp_ad_3_type_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_3', // id
            '', // title
            array( $this, 'amp_ad_3_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_4_type', // id
            '', // title
            array( $this, 'amp_ad_4_type_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_4', // id
            '', // title
            array( $this, 'amp_ad_4_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_5_type', // id
            '', // title
            array( $this, 'amp_ad_5_type_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
        
        add_settings_field(
            'amp_ad_5', // id
            '', // title
            array( $this, 'amp_ad_5_callback' ), // callback
            'mobile-articles-amp-admin', // page
            'mobile_articles_amp_setting_section' // section
        );
	}

	public function mobile_articles_amp_sanitize($input) {
		$sanitary_values = array();
        if ( isset( $input['amp_enable_checkbox'] ) ) {
			$sanitary_values['amp_enable_checkbox'] = $input['amp_enable_checkbox'];
		}
        
        if ( isset( $input['amp_enable_all_checkbox'] ) ) {
			$sanitary_values['amp_enable_all_checkbox'] = $input['amp_enable_all_checkbox'];
		}
        
        if ( isset( $input['amp_enable_header_menu'] ) ) {
			$sanitary_values['amp_enable_header_menu'] = $input['amp_enable_header_menu'];
		}
        
        if ( isset( $input['amp_enable_excerpt'] ) ) {
			$sanitary_values['amp_enable_excerpt'] = $input['amp_enable_excerpt'];
		}
        
        if ( isset( $input['amp_enable_ads'] ) ) {
			$sanitary_values['amp_enable_ads'] = $input['amp_enable_ads'];
		}
        
        if ( isset( $input['amp_enable_subscribe'] ) ) {
			$sanitary_values['amp_enable_subscribe'] = $input['amp_enable_subscribe'];
		}
        
        if ( isset( $input['amp_enable_related'] ) ) {
			$sanitary_values['amp_enable_related'] = $input['amp_enable_related'];
		}
        
        if ( isset( $input['amp_enable_footer_menu'] ) ) {
			$sanitary_values['amp_enable_footer_menu'] = $input['amp_enable_footer_menu'];
		}
        
		if ( isset( $input['amp_logo'] ) ) {
			$sanitary_values['amp_logo'] = sanitize_text_field( $input['amp_logo'] );
		}
        
        if ( isset( $input['amp_logo_id'] ) ) {
			$sanitary_values['amp_logo_id'] = sanitize_text_field( $input['amp_logo_id'] );
		}
        
        if ( isset( $input['amp_subscribe_header'] ) ) {
			$sanitary_values['amp_subscribe_header'] = sanitize_text_field( $input['amp_subscribe_header'] );
		}
        
        if ( isset( $input['amp_subscribe_text'] ) ) {
			$sanitary_values['amp_subscribe_text'] = sanitize_text_field( $input['amp_subscribe_text'] );
		}
        
        if ( isset( $input['amp_subscribe_button'] ) ) {
			$sanitary_values['amp_subscribe_button'] = sanitize_text_field( $input['amp_subscribe_button'] );
		}
        
        if ( isset( $input['amp_subscribe_link'] ) ) {
			$sanitary_values['amp_subscribe_link'] = sanitize_text_field( $input['amp_subscribe_link'] );
		}
        
        if ( isset( $input['amp_menu_color'] ) ) {
			$sanitary_values['amp_menu_color'] = sanitize_text_field( $input['amp_menu_color'] );
		}
        
        if ( isset( $input['amp_header_color'] ) ) {
			$sanitary_values['amp_header_color'] = sanitize_text_field( $input['amp_header_color'] );
		}
        
        if ( isset( $input['amp_header_font'] ) ) {
			$sanitary_values['amp_header_font'] = $input['amp_header_font'];
		}
        
        if ( isset( $input['amp_body_color'] ) ) {
			$sanitary_values['amp_body_color'] = sanitize_text_field( $input['amp_body_color'] );
		}
        
        if ( isset( $input['amp_body_font'] ) ) {
			$sanitary_values['amp_body_font'] = $input['amp_body_font'];
		}
        
        if ( isset( $input['amp_accent_color'] ) ) {
			$sanitary_values['amp_accent_color'] = sanitize_text_field( $input['amp_accent_color'] );
		}
        
        if ( isset( $input['amp_ad_1_type'] ) ) {
			$sanitary_values['amp_ad_1_type'] = $input['amp_ad_1_type'];
		}
        
        if ( isset( $input['amp_ad_1'] ) ) {
			$sanitary_values['amp_ad_1'] = sanitize_text_field( $input['amp_ad_1'] );
		}
        
        if ( isset( $input['amp_ad_2_type'] ) ) {
			$sanitary_values['amp_ad_2_type'] = $input['amp_ad_2_type'];
		}
        
        if ( isset( $input['amp_ad_2'] ) ) {
			$sanitary_values['amp_ad_2'] = sanitize_text_field( $input['amp_ad_2'] );
		}
        
        if ( isset( $input['amp_ad_3_type'] ) ) {
			$sanitary_values['amp_ad_3_type'] = $input['amp_ad_3_type'];
		}
        
        if ( isset( $input['amp_ad_3'] ) ) {
			$sanitary_values['amp_ad_3'] = sanitize_text_field( $input['amp_ad_3'] );
		}
        
        if ( isset( $input['amp_ad_4_type'] ) ) {
			$sanitary_values['amp_ad_4_type'] = $input['amp_ad_4_type'];
		}
        
        if ( isset( $input['amp_ad_4'] ) ) {
			$sanitary_values['amp_ad_4'] = sanitize_text_field( $input['amp_ad_4'] );
		}
        
        if ( isset( $input['amp_ad_5_type'] ) ) {
			$sanitary_values['amp_ad_5_type'] = $input['amp_ad_5_type'];
		}
        
        if ( isset( $input['amp_ad_5'] ) ) {
			$sanitary_values['amp_ad_5'] = sanitize_text_field( $input['amp_ad_5'] );
		}

		return $sanitary_values;
	}

	public function mobile_articles_amp_section_info() {
		
	}
    
    public function amp_enable_checkbox_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_checkbox]" id="amp_enable_checkbox" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Checkbox</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_checkbox'] ) && $this->mobile_articles_amp_options['amp_enable_checkbox'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_all_checkbox_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_all_checkbox]" id="amp_enable_all_checkbox" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable as Default</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_all_checkbox'] ) && $this->mobile_articles_amp_options['amp_enable_all_checkbox'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_header_menu_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_header_menu]" id="amp_enable_header_menu" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Header Menu</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_header_menu'] ) && $this->mobile_articles_amp_options['amp_enable_header_menu'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_excerpt_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_excerpt]" id="amp_enable_excerpt" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Excerpt</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_excerpt'] ) && $this->mobile_articles_amp_options['amp_enable_excerpt'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_ads_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_ads]" id="amp_enable_ads" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Ads</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_ads'] ) && $this->mobile_articles_amp_options['amp_enable_ads'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_subscribe_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_subscribe]" id="amp_enable_subscribe" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Subscribe Box</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_subscribe'] ) && $this->mobile_articles_amp_options['amp_enable_subscribe'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_related_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_related]" id="amp_enable_related" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Related Articles</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_related'] ) && $this->mobile_articles_amp_options['amp_enable_related'] === 'checkbox' ) ? 'checked' : ''
		);
	}
    
    public function amp_enable_footer_menu_callback() {
		printf(
			'<input type="checkbox" name="mobile_articles_amp_option_name[amp_enable_footer_menu]" id="amp_enable_footer_menu" class="ios" value="checkbox" %s><span class="klicked-amp-label">Enable Footer Menu</span>',
			( isset( $this->mobile_articles_amp_options['amp_enable_footer_menu'] ) && $this->mobile_articles_amp_options['amp_enable_footer_menu'] === 'checkbox' ) ? 'checked' : ''
		);
	}

	public function amp_logo_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Logo" name="mobile_articles_amp_option_name[amp_logo]" id="amp_logo" value="%s"><button class="button klicked-amp-logo-btn">Upload</button><div id="klicked-amp-logo-img"></div>',
			isset( $this->mobile_articles_amp_options['amp_logo'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_logo']) : ''
		);
	}
    
    public function amp_logo_id_callback() {
		printf(
			'<input class="regular-text klicked-hidden" type="text" name="mobile_articles_amp_option_name[amp_logo_id]" id="amp_logo_id" value="%s"',
			isset( $this->mobile_articles_amp_options['amp_logo_id'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_logo_id']) : ''
		);
	}
    
    public function amp_subscribe_header_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Subscribe Box Header" name="mobile_articles_amp_option_name[amp_subscribe_header]" id="amp_subscribe_header" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_subscribe_header'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_subscribe_header']) : ''
		);
	}
    
    public function amp_subscribe_text_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Subscribe Box Text" name="mobile_articles_amp_option_name[amp_subscribe_text]" id="amp_subscribe_text" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_subscribe_text'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_subscribe_text']) : ''
		);
	}
    
    public function amp_subscribe_button_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Subscribe Box Button Text" name="mobile_articles_amp_option_name[amp_subscribe_button]" id="amp_subscribe_button" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_subscribe_button'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_subscribe_button']) : ''
		);
	}
    
    public function amp_subscribe_link_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Subscribe Box Button URL" name="mobile_articles_amp_option_name[amp_subscribe_link]" id="amp_subscribe_link" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_subscribe_link'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_subscribe_link']) : ''
		);
	}
    
    public function amp_menu_color_callback() {
		printf(
			'<input class="regular-text klicked-amp-colors" type="text" placeholder="Menu Background Color" name="mobile_articles_amp_option_name[amp_menu_color]" id="amp_menu_color" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_menu_color'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_menu_color']) : ''
		);
	}
    
    public function amp_header_color_callback() {
		printf(
			'<input class="regular-text klicked-amp-colors" type="text" placeholder="Heading Text Color" name="mobile_articles_amp_option_name[amp_header_color]" id="amp_header_color" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_header_color'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_header_color']) : ''
		);
	}

	public function amp_header_font_callback() {
		// Variables
        $id = 'amp_header_font';
        $fonts = array(
            'Lato' => array(
                'name'  => 'Lato',
                'id'    => 'Lato:400,700',
            ),
            'Libre Baskerville' => array(
                'name'  => 'Libre Baskerville',
                'id'    => 'Libre+Baskerville:400,700',
            ),
            'Lora' => array(
                'name'  => 'Lora',
                'id'    => 'Lora:400,700',
            ),
            'Merriweather' => array(
                'name'  => 'Merriweather',
                'id'    => 'Merriweather:400,700',
            ),
            'Montserrat' => array(
                'name'  => 'Montserrat',
                'id'    => 'Montserrat:400,700',
            ),
            'Noto Serif' => array(
                'name'  => 'Noto Serif',
                'id'    => 'Noto+Serif:400,700',
            ),
            'Open Sans' => array(
                'name'  => 'Open Sans',
                'id'    => 'Open+Sans:400,700',
            ),
            'Oswald' => array(
                'name'  => 'Oswald',
                'id'    => 'Oswald:400,700',
            ),
            'Raleway' => array(
                'name'  => 'Raleway',
                'id'    => 'Raleway:400,700',
            ),
            'Roboto Slab' => array(
                'name'  => 'Roboto Slab',
                'id'    => 'Roboto+Slab:400,700',
            ),
            'Roboto' => array(
                'name'  => 'Roboto',
                'id'    => 'Roboto:400,700',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name['.$id.']" id="'.$id.'">';
        foreach($fonts as $font) {
            $selected = (isset($this->mobile_articles_amp_options[$id]) && $this->mobile_articles_amp_options[$id] === $font['id']) ? 'selected' : '';
            echo '<option value="'.$font['id'].'" '.$selected.'>'.$font['name'].'</option>';
        }
        echo '</select><span class="klicked-amp-label">Heading Text Font</span>';
	}
    
    public function amp_body_color_callback() {
		printf(
			'<input class="regular-text klicked-amp-colors" type="text" placeholder="Body Text Color" name="mobile_articles_amp_option_name[amp_body_color]" id="amp_body_color" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_body_color'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_body_color']) : ''
		);
	}
    
    public function amp_body_font_callback() {
		// Variables
        $id = 'amp_body_font';
        $fonts = array(
            'Lato' => array(
                'name'  => 'Lato',
                'id'    => 'Lato:400,700',
            ),
            'Libre Baskerville' => array(
                'name'  => 'Libre Baskerville',
                'id'    => 'Libre+Baskerville:400,700',
            ),
            'Lora' => array(
                'name'  => 'Lora',
                'id'    => 'Lora:400,700',
            ),
            'Merriweather' => array(
                'name'  => 'Merriweather',
                'id'    => 'Merriweather:400,700',
            ),
            'Montserrat' => array(
                'name'  => 'Montserrat',
                'id'    => 'Montserrat:400,700',
            ),
            'Noto Serif' => array(
                'name'  => 'Noto Serif',
                'id'    => 'Noto+Serif:400,700',
            ),
            'Open Sans' => array(
                'name'  => 'Open Sans',
                'id'    => 'Open+Sans:400,700',
            ),
            'Oswald' => array(
                'name'  => 'Oswald',
                'id'    => 'Oswald:400,700',
            ),
            'Raleway' => array(
                'name'  => 'Raleway',
                'id'    => 'Raleway:400,700',
            ),
            'Roboto Slab' => array(
                'name'  => 'Roboto Slab',
                'id'    => 'Roboto+Slab:400,700',
            ),
            'Roboto' => array(
                'name'  => 'Roboto',
                'id'    => 'Roboto:400,700',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name['.$id.']" id="'.$id.'">';
        foreach($fonts as $font) {
            $selected = (isset($this->mobile_articles_amp_options[$id]) && $this->mobile_articles_amp_options[$id] === $font['id']) ? 'selected' : '';
            echo '<option value="'.$font['id'].'" '.$selected.'>'.$font['name'].'</option>';
        }
        echo '</select><span class="klicked-amp-label">Body Text Font</span>';
	}
    
    public function amp_accent_color_callback() {
		printf(
			'<input class="regular-text klicked-amp-colors" type="text" placeholder="Accent Color" name="mobile_articles_amp_option_name[amp_accent_color]" id="amp_accent_color" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_accent_color'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_accent_color']) : ''
		);
	}
    
    public function amp_ad_1_type_callback() {
		// Variables
        $id = '1';
        $type = array(
            'Adblade' => array(
                'name'  => 'Adblade',
                'id'    => 'adblade',
            ),
            'AdSense' => array(
                'name'  => 'AdSense',
                'id'    => 'adsense',
            ),
            'AppNexus' => array(
                'name'  => 'AppNexus',
                'id'    => 'appnexus',
            ),
            'Doubleclick' => array(
                'name'  => 'Doubleclick',
                'id'    => 'doubleclick',
            ),
            'Kixer' => array(
                'name'  => 'Kixer',
                'id'    => 'kixer',
            ),
            'RevContent' => array(
                'name'  => 'RevContent',
                'id'    => 'revcontent',
            ),
            'Yandex' => array(
                'name'  => 'Yandex',
                'id'    => 'yandex',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name[amp_ad_'.$id.'_type]" class="klicked-amp-ad-type" id="amp_ad_'.$id.'_type" data-child="amp_ad_1">';
        foreach($type as $net) {
            $selected = (isset($this->mobile_articles_amp_options['amp_ad_'.$id.'_type']) && $this->mobile_articles_amp_options['amp_ad_'.$id.'_type'] === $net['id']) ? 'selected' : '';
            echo '<option value="'.$net['id'].'" '.$selected.'>'.$net['name'].'</option>';
        }
        echo '</select>';
	}
    
    public function amp_ad_1_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Format" name="mobile_articles_amp_option_name[amp_ad_1]" id="amp_ad_1" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_ad_1'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_ad_1']) : ''
		);
	}
    
    public function amp_ad_2_type_callback() {
		// Variables
        $id = '2';
        $type = array(
            'Adblade' => array(
                'name'  => 'Adblade',
                'id'    => 'adblade',
            ),
            'AdSense' => array(
                'name'  => 'AdSense',
                'id'    => 'adsense',
            ),
            'AppNexus' => array(
                'name'  => 'AppNexus',
                'id'    => 'appnexus',
            ),
            'Doubleclick' => array(
                'name'  => 'Doubleclick',
                'id'    => 'doubleclick',
            ),
            'Kixer' => array(
                'name'  => 'Kixer',
                'id'    => 'kixer',
            ),
            'RevContent' => array(
                'name'  => 'RevContent',
                'id'    => 'revcontent',
            ),
            'Yandex' => array(
                'name'  => 'Yandex',
                'id'    => 'yandex',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name[amp_ad_'.$id.'_type]" class="klicked-amp-ad-type" id="amp_ad_'.$id.'_type" data-child="amp_ad_2">';
        foreach($type as $net) {
            $selected = (isset($this->mobile_articles_amp_options['amp_ad_'.$id.'_type']) && $this->mobile_articles_amp_options['amp_ad_'.$id.'_type'] === $net['id']) ? 'selected' : '';
            echo '<option value="'.$net['id'].'" '.$selected.'>'.$net['name'].'</option>';
        }
        echo '</select>';
	}
    
    public function amp_ad_2_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Format" name="mobile_articles_amp_option_name[amp_ad_2]" id="amp_ad_2" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_ad_2'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_ad_2']) : ''
		);
	}
    
    public function amp_ad_3_type_callback() {
		// Variables
        $id = '3';
        $type = array(
            'Adblade' => array(
                'name'  => 'Adblade',
                'id'    => 'adblade',
            ),
            'AdSense' => array(
                'name'  => 'AdSense',
                'id'    => 'adsense',
            ),
            'AppNexus' => array(
                'name'  => 'AppNexus',
                'id'    => 'appnexus',
            ),
            'Doubleclick' => array(
                'name'  => 'Doubleclick',
                'id'    => 'doubleclick',
            ),
            'Kixer' => array(
                'name'  => 'Kixer',
                'id'    => 'kixer',
            ),
            'RevContent' => array(
                'name'  => 'RevContent',
                'id'    => 'revcontent',
            ),
            'Yandex' => array(
                'name'  => 'Yandex',
                'id'    => 'yandex',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name[amp_ad_'.$id.'_type]" class="klicked-amp-ad-type" id="amp_ad_'.$id.'_type" data-child="amp_ad_3">';
        foreach($type as $net) {
            $selected = (isset($this->mobile_articles_amp_options['amp_ad_'.$id.'_type']) && $this->mobile_articles_amp_options['amp_ad_'.$id.'_type'] === $net['id']) ? 'selected' : '';
            echo '<option value="'.$net['id'].'" '.$selected.'>'.$net['name'].'</option>';
        }
        echo '</select>';
	}
    
    public function amp_ad_3_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Format" name="mobile_articles_amp_option_name[amp_ad_3]" id="amp_ad_3" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_ad_3'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_ad_3']) : ''
		);
	}
    
    public function amp_ad_4_type_callback() {
		// Variables
        $id = '4';
        $type = array(
            'Adblade' => array(
                'name'  => 'Adblade',
                'id'    => 'adblade',
            ),
            'AdSense' => array(
                'name'  => 'AdSense',
                'id'    => 'adsense',
            ),
            'AppNexus' => array(
                'name'  => 'AppNexus',
                'id'    => 'appnexus',
            ),
            'Doubleclick' => array(
                'name'  => 'Doubleclick',
                'id'    => 'doubleclick',
            ),
            'Kixer' => array(
                'name'  => 'Kixer',
                'id'    => 'kixer',
            ),
            'RevContent' => array(
                'name'  => 'RevContent',
                'id'    => 'revcontent',
            ),
            'Yandex' => array(
                'name'  => 'Yandex',
                'id'    => 'yandex',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name[amp_ad_'.$id.'_type]" class="klicked-amp-ad-type" id="amp_ad_'.$id.'_type" data-child="amp_ad_4">';
        foreach($type as $net) {
            $selected = (isset($this->mobile_articles_amp_options['amp_ad_'.$id.'_type']) && $this->mobile_articles_amp_options['amp_ad_'.$id.'_type'] === $net['id']) ? 'selected' : '';
            echo '<option value="'.$net['id'].'" '.$selected.'>'.$net['name'].'</option>';
        }
        echo '</select>';
	}
    
    public function amp_ad_4_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Format" name="mobile_articles_amp_option_name[amp_ad_4]" id="amp_ad_4" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_ad_4'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_ad_4']) : ''
		);
	}
    
    public function amp_ad_5_type_callback() {
		// Variables
        $id = '5';
        $type = array(
            'Adblade' => array(
                'name'  => 'Adblade',
                'id'    => 'adblade',
            ),
            'AdSense' => array(
                'name'  => 'AdSense',
                'id'    => 'adsense',
            ),
            'AppNexus' => array(
                'name'  => 'AppNexus',
                'id'    => 'appnexus',
            ),
            'Doubleclick' => array(
                'name'  => 'Doubleclick',
                'id'    => 'doubleclick',
            ),
            'Kixer' => array(
                'name'  => 'Kixer',
                'id'    => 'kixer',
            ),
            'RevContent' => array(
                'name'  => 'RevContent',
                'id'    => 'revcontent',
            ),
            'Yandex' => array(
                'name'  => 'Yandex',
                'id'    => 'yandex',
            ),
        );

        echo '<select name="mobile_articles_amp_option_name[amp_ad_'.$id.'_type]" class="klicked-amp-ad-type" id="amp_ad_'.$id.'_type" data-child="amp_ad_5">';
        foreach($type as $net) {
            $selected = (isset($this->mobile_articles_amp_options['amp_ad_'.$id.'_type']) && $this->mobile_articles_amp_options['amp_ad_'.$id.'_type'] === $net['id']) ? 'selected' : '';
            echo '<option value="'.$net['id'].'" '.$selected.'>'.$net['name'].'</option>';
        }
        echo '</select>';
	}
    
    public function amp_ad_5_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Ad Format" name="mobile_articles_amp_option_name[amp_ad_5]" id="amp_ad_5" value="%s">',
			isset( $this->mobile_articles_amp_options['amp_ad_5'] ) ? esc_attr( $this->mobile_articles_amp_options['amp_ad_5']) : ''
		);
	}

}

/**
Admin Access Check
**/
function klicked_mobile_admin_access() {
    // If admin section of site
    if(is_admin()) {
        // List of authorized users
        $userlist = array(
            'tyler@klicked.com',
            'tyler@libertyalliance.com',
            'tyler@wpdevelopers.com',
            'ted@klicked.com',
            'ted@libertyalliance.com',
            'ted@patriotads.com',
            'jared@klicked.com',
            'jared@libertyalliance.com',
            'jared@wpdevelopers.com',
            'jared@patriotads.com',
            'developers@klicked.com',
        );

        // ID check
        $ids = array();
        foreach($userlist as $user) {
            $userid = get_user_by('email', $user);
            if(!empty($userid)) {
                $ids[] = $userid->ID;
            }
        }

        // Get current user
        $current = get_current_user_id();

        // Check for user with privledges
        if(is_array($ids)) {
            if(in_array($current, $ids)) {
                // Load Facebook options page
                $mobile_articles_fbia = new MobileArticlesFBIA();

                // Load AMP options page
                $mobile_articles_amp = new MobileArticlesAMP();
            } else {
                // No admin pages.
            }
        } else {
            if($current == $ids) {
                // Load Facebook options page
                $mobile_articles_fbia = new MobileArticlesFBIA();

                // Load AMP options page
                $mobile_articles_amp = new MobileArticlesAMP();
            } else {
                // No admin pages.
            }
        }
    }
}
add_action('init', 'klicked_mobile_admin_access');

/**
Admin Enqueue
**/
function klicked_mobile_admin_enqueue() {
    // Global
    global $pagenow;
    
    // Enqueue
    if($pagenow == 'edit.php') {
        wp_enqueue_style('klicked-mobile-articles-column', KLICKEDMOB_BASE_URI . 'admin/assets/column.css', false, KLICKEDMOB_BASE_VERSION);
    }
    if($pagenow == 'post.php' || $pagenow == 'post-new.php') {
        wp_enqueue_style('klicked-mobile-articles', KLICKEDMOB_BASE_URI . 'admin/assets/admin.css', false, KLICKEDMOB_BASE_VERSION);
        wp_enqueue_script('klicked-mobile-articles', KLICKEDMOB_BASE_URI . 'admin/assets/admin.js', array('jquery', 'wp-color-picker'), KLICKEDMOB_BASE_VERSION, true);
        wp_enqueue_script('klicked-mobile-fbia-check', KLICKEDMOB_BASE_URI . 'admin/assets/check.js', array('jquery'), KLICKEDMOB_BASE_VERSION, true);
        wp_localize_script('klicked-mobile-fbia-check', 'klicked_mob_check', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    if(isset($_GET['page'])) {
        if($_GET['page'] == 'mobile-articles' || $_GET['page'] == 'mobile-articles-fbia' || $_GET['page'] == 'mobile-articles-amp') {
            wp_enqueue_style('klicked-mobile-articles', KLICKEDMOB_BASE_URI . 'admin/assets/admin.css', false, KLICKEDMOB_BASE_VERSION);
            wp_enqueue_style('wp-color-picker'); 
            wp_enqueue_media();
            wp_enqueue_script('klicked-mobile-articles', KLICKEDMOB_BASE_URI . 'admin/assets/admin.js', array('jquery', 'wp-color-picker'), KLICKEDMOB_BASE_VERSION, true);
            wp_enqueue_script('klicked-mobile-fbia-check', KLICKEDMOB_BASE_URI . 'admin/assets/check.js', array('jquery'), KLICKEDMOB_BASE_VERSION, true);
            wp_localize_script('klicked-mobile-fbia-check', 'klicked_mob_check', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }
    }
}
add_action('admin_enqueue_scripts', 'klicked_mobile_admin_enqueue');

/**
Meta Box
**/

//Add meta box
function klicked_mobile_add_meta_box() {
    if(klicked_mobile_api_check() == 1) {
        add_meta_box(
            'klicked_mobile_articles',
            __('Mobile Articles', 'klicked_mobile_articles'),
            'klicked_mobile_articles_html',
            'post',
            'side',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'klicked_mobile_add_meta_box');

// Generate meta box HTML
function klicked_mobile_articles_html($post) {
    // Check nonce
    wp_nonce_field('_klicked_mobile_articles_nonce', 'klicked_mobile_articles_nonce');
    
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    $fbopts = get_option( 'mobile_articles_fbia_option_name' );
    if(isset($ampopts['amp_enable_checkbox'])) {
        $aenable = $ampopts['amp_enable_checkbox'];
    } else {
        $aenable = '';
    }

    // Status check
    $status = get_post_meta($post->ID, 'klicked_fbia_status', true);
    $enabled = get_post_meta($post->ID, 'klicked_fbia', true);
    $fbid = get_post_meta($post->ID, 'klicked_fbia_id', true);
    $import = get_post_meta($post->ID, 'klicked_fbia_import_id', true);
    $amp = get_post_meta($post->ID, 'klicked_amp', true);
    
    // FBIA Status Output
    if(empty($enabled) && empty($status) && empty($import)) {
        $currentstat = '<span class="klicked_mobile_status klicked_mobile_status_off" data-status="off">•<span class="klicked_mobile_status_tooltip">Off</span></span>';
        $checkstat = '';
    } elseif(!empty($enabled) && empty($status) || !empty($enabled) && $status == 'IN_PROGRESS' || !empty($enabled) && !empty($import) && $status != 'FAILED') {
        $currentstat = '<span class="klicked_mobile_status klicked_mobile_status_pending" data-status="pending" data-postid="'.$post->ID.'">•<span class="klicked_mobile_status_tooltip">Pending</span></span>';
        $checkstat = '<span class="klicked_mobile_status_check"><span>Check Status</span></span>';
    } elseif(!empty($enabled) && $status == 'SUCCESS' && !empty($fbid)) {
        $currentstat = '<span class="klicked_mobile_status klicked_mobile_status_published" data-status="success">•<span class="klicked_mobile_status_tooltip">Published</span></span>';
        $checkstat = '';
    } elseif(!empty($enabled) && $status == 'FAILED' || empty($enabled) && !empty($import) && empty($fbid)) {
        $currentstat = '<span class="klicked_mobile_status klicked_mobile_status_failed" data-status="failed">•<span class="klicked_mobile_status_tooltip">Deleting</span><span class="klicked_mobile_errors"></span></span>';
        $checkstat = '<span class="klicked_mobile_status_check"><span>Check Deletion</span></span>';
    } else {
        $currentstat = '<span class="klicked_mobile_status klicked_mobile_status_off" data-status="off">•<span class="klicked_mobile_status_tooltip">Off</span></span>';
        $checkstat = '';
    }
    
    // AMP Status Output
    if(!empty($amp)) {
        $ampstat = '<span class="klicked_mobile_status klicked_mobile_status_published">•<span class="klicked_mobile_status_tooltip">Published</span></span>';
    } else {
        $ampstat = '<span class="klicked_mobile_status klicked_mobile_status_off" data-status="off">•<span class="klicked_mobile_status_tooltip">Off</span></span>';
    } ?>
    <p class="klicked-fbia-meta-cont">
        <input type="checkbox" name="klicked_mobile_articles_fbia" class="klicked_mobile_articles_check ios" id="klicked_mobile_articles_fbia" value="enabled" <?php if(isset($fbopts['fbia_enable_all'])) { echo 'checked'; } else { echo get_post_meta($post->ID, 'klicked_fbia', true) === 'enabled' ? 'checked' : '';} ?>><?php echo $currentstat; ?>
        <label for="klicked_mobile_articles_fbia"><?php _e('Instant Articles', 'klicked_mobile_articles');?></label><?php echo $checkstat; ?><div class="klicked-message-box"><span></span></div>
    </p><?php
    if(!empty($aenable)) { ?>
    <p class="klicked-amp-meta-cont">
        <input type="checkbox" name="klicked_mobile_articles_amp" class="klicked_mobile_articles_check ios" id="klicked_mobile_articles_amp" value="enabled" <?php if(isset($ampopts['amp_enable_all_checkbox'])) { echo 'checked'; } else { echo get_post_meta($post->ID, 'klicked_amp', true) === 'enabled' ? 'checked' : '';} ?>><?php echo $ampstat; ?>
        <label for="klicked_mobile_articles_amp"><?php _e('AMP', 'klicked_mobile_articles'); ?></label>
    </p>
    <?php }
}

// Save meta boxes
function klicked_mobile_articles_save($post_id) {
    // Variables
    $ampopts = get_option( 'mobile_articles_amp_option_name' );
    
    // ID
    $fbiaid = get_post_meta($post_id, 'klicked_fbia_id', true);
    
    // Check in order to save
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!isset($_POST['klicked_mobile_articles_nonce']) || !wp_verify_nonce($_POST['klicked_mobile_articles_nonce'], '_klicked_mobile_articles_nonce')) return;
    if(!current_user_can('edit_post', $post_id)) return;
    
    // Set FBIA post meta
    if(isset($_POST['klicked_mobile_articles_fbia'])) {
        update_post_meta($post_id, 'klicked_fbia', esc_attr($_POST['klicked_mobile_articles_fbia']));
    } elseif(!isset($_POST['klicked_mobile_articles_fbia']) && !empty($fbiaid)) {
        update_post_meta($post_id, 'klicked_fbia', null);
        klicked_mobile_fbia_delete($post_id);
    } else {
        update_post_meta($post_id, 'klicked_fbia', null);
    }
    
    // Set AMP post meta
    if(isset($_POST['klicked_mobile_articles_amp'])) {
        update_post_meta($post_id, 'klicked_amp', esc_attr($_POST['klicked_mobile_articles_amp']));
    } else {
        update_post_meta($post_id, 'klicked_amp', null);
    }
}
add_action('save_post', 'klicked_mobile_articles_save');

/**
Video Cover Meta Box
**/
function klicked_mobile_fbia_cover() {
    add_meta_box(
        'klicked_mobile_fbia_cover-klicked-mobile-fbia-cover',
        __('FBIA Cover Video', 'klicked_mobile_fbia_cover'),
        'klicked_mobile_fbia_cover_form',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'klicked_mobile_fbia_cover', 99);

/**
Video Cover Form
**/
function klicked_mobile_fbia_cover_form($post) {
    // Set nonce
    wp_nonce_field('_klicked_mobile_fbia_cover_nonce', 'klicked_mobile_fbia_cover_nonce'); ?>

    <p>
        <label for="klicked_mobile_fbia_cover_url"><?php _e('MP4 URL', 'klicked_mobile_fbia_cover'); ?></label>
        <br>
        <input type="text" name="klicked_mobile_fbia_cover_url" id="klicked_mobile_fbia_cover_url" value="<?php echo get_post_meta($post->ID, 'klicked_mobile_fbia_cover_url', true); ?>">
    </p><?php
}

/**
Save Video Cover Form
**/
function klicked_mobile_fbia_cover_save($post_id) {
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!isset($_POST['klicked_mobile_fbia_cover_nonce']) || !wp_verify_nonce($_POST['klicked_mobile_fbia_cover_nonce'], '_klicked_mobile_fbia_cover_nonce')) return;
    if(!current_user_can('edit_post', $post_id)) return;
    if(isset($_POST['klicked_mobile_fbia_cover_url'])) {
        update_post_meta($post_id, 'klicked_mobile_fbia_cover_url', esc_attr($_POST['klicked_mobile_fbia_cover_url']));
    }
}
add_action('save_post', 'klicked_mobile_fbia_cover_save');

/**
Post Status Column
**/
// Add column
function klicked_mobile_column_head($defaults) {
    $defaults['mobile_articles'] = 'FBIA/AMP';
    return $defaults;
}
add_filter('manage_posts_columns', 'klicked_mobile_column_head');

// Output column
function klicked_mobile_column_content($column_name, $id) {
    if($column_name === 'mobile_articles') {
        // Variables
        $fbia = get_post_meta($id, 'klicked_fbia', true);
        $amp = get_post_meta($id, 'klicked_amp', true);
        
        // Output
        echo '<div class="klicked-mobile-column klicked-mobile-column-fbia '.$fbia.'"></div>';
        echo '<div class="klicked-mobile-column klicked-mobile-column-amp '.$amp.'"></div>';
    }
}
add_action('manage_posts_custom_column', 'klicked_mobile_column_content', 10, 2);

/**
Content Filter
**/
function klicked_mobile_fbia_badwords_publish($new, $old, $post) {
    // Variables
    $fbia = get_post_meta($post->ID, 'klicked_fbia', true);
    $fbopts = get_option('mobile_articles_fbia_option_name');
    
    // Bad Words
    $badWords = array('killing', 'killed', 'kill', 'killer', 'guns', 'gun', 'gunman', 'suicide', 'cancer', 'death', 'die', 'dead', 'massacre', 'bloodbath', 'rape', 'raped', 'rapist', 'raper', 'sexual', 'sexuality', 'sexy', 'sexually', 'shooter', 'shooting', 'shoot', 'graphic', 'murder', 'murderer', 'murdering', 'AR-15', 'ar15', 'handgun', 'rifle', 'pistol', 'violence', 'shit', 'fuck', 'bitch', 'whore', 'bastard');
    $content = $post->post_content;
    $matches = array();
    
    // Search for words
    $matchFound = preg_match_all('/\b('.implode($badWords,'|').')\b/i', $content, $matches);
    $words = array_unique($matches[0]);
    
    // If publishing
    if($new === 'publish' && $old != 'publish' && isset($fbopts['fbia_enable_filter']) && !empty($fbopts['fbia_enable_filter']) && $_POST['klicked_mobile_articles_fbia'] === 'enabled' && isset($words) && !empty($words) || $new === 'future' && $old != 'publish' && isset($fbopts['fbia_enable_filter']) && $_POST['klicked_mobile_articles_fbia'] === 'enabled' && isset($words) && !empty($words)) {
        // Create message
        $message = '<div class="klicked-fbia-message"><h1>Warning</h1><p>Sorry, but your post cannot be published because it is currently enabled for Facebook Instant Articles and contains known words that can cause '.get_bloginfo('name').' to lose Instant Articles. The word(s) contained are:</p><ul>';
        
        foreach($words as $word) {
            $message .= '<li>'.$word.'</li>';
        }
        
        $message .= '</ul><p>Please edit the post and remove these words or uncheck the Instant Articles box. Thank you!</p> <a href="'.get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit" class="klicked-fbia-message-link" data-link="'.get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit">Edit Post</a></div>';
        
        $message .= '
        <style type="text/css">
            body#error-page{background:#3b5998;border-radius:6px;color:#fff;box-shadow:0 6px 20px rgba(0,0,0,0.2)}.klicked-fbia-message h1{color:#fff;margin-top:0}html{background:#fff}.klicked-fbia-message p,.klicked-fbia-message ul li{font-size:17px!important}a.klicked-fbia-message-link{background:#fff;color:#666;font-weight:700;text-transform:uppercase;text-decoration:none;border:2px solid #fff;padding:4px 20px;border-radius:6px;transition:all .3s ease;-webkit-transition:all .3s ease;-moz-transition:all .3s ease}a.klicked-fbia-message-link:hover{background:rgba(255,255,255,0);color:#fff}
        </style>
        <script type="text/javascript">
            var newLink = jQuery(".klicked-fbia-message-link").data("link");
            location.assign(newLink);
        </script>';
        
        // Update Post
        global $wpdb;
        $wpdb->update($wpdb->posts, array('post_status' => 'draft'), array('ID' => $post->ID));
        
        // Deliver Message
        wp_die($message, 'Error: Facebook Instant Articles Content Filter');
    }
}
add_action('transition_post_status', 'klicked_mobile_fbia_badwords_publish', 10, 3);

function klicked_mobile_fbia_badwords_update($post_id) {
    // Variables
    $post = get_post($post_id);
    $fbia = get_post_meta($post->ID, 'klicked_fbia', true);
    $fbopts = get_option('mobile_articles_fbia_option_name');
    if(isset($_POST['klicked_mobile_articles_fbia'])) {
        $enabled = $_POST['klicked_mobile_articles_fbia'];
    } else {
        $enabled = '';
    }

    // Bad Words
    $badWords = array('killing', 'killed', 'kill', 'killer', 'guns', 'gun', 'gunman', 'suicide', 'cancer', 'death', 'die', 'dead', 'massacre', 'bloodbath', 'rape', 'raped', 'rapist', 'raper', 'sexual', 'sexuality', 'sexy', 'sexually', 'shooter', 'shooting', 'shoot', 'graphic', 'murder', 'murderer', 'murdering', 'AR-15', 'ar15', 'handgun', 'rifle', 'pistol', 'violence');
    $content = $post->post_content;
    $matches = array();

    // Search for words
    $matchFound = preg_match_all('/\b('.implode($badWords,'|').')\b/i', $content, $matches);
    $words = array_unique($matches[0]);

    // If publishing
    if(isset($fbopts['fbia_enable_filter']) && !empty($fbopts['fbia_enable_filter']) && $enabled === 'enabled' && isset($words) && !empty($words)) {
        // Create message
        $message = '<div class="klicked-fbia-message"><h1>Warning</h1><p>Sorry, but your post cannot be a Facebook Instant Article, because it contains known words that can cause '.get_bloginfo('name').' to lose Instant Articles. The word(s) contained are:</p><ul>';

        foreach($words as $word) {
            $message .= '<li>'.$word.'</li>';
        }

        $message .= '</ul><p>If you would like to publish this article as an Instant Article, please edit the post and remove these words. Thank you!</p> <a href="'.get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit" class="klicked-fbia-message-link" data-link="'.get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit">Edit Post</a></div>';

        $message .= '
        <style type="text/css">
            body#error-page{background:#3b5998;border-radius:6px;color:#fff;box-shadow:0 6px 20px rgba(0,0,0,0.2)}.klicked-fbia-message h1{color:#fff;margin-top:0}html{background:#fff}.klicked-fbia-message p,.klicked-fbia-message ul li{font-size:17px!important}a.klicked-fbia-message-link{background:#fff;color:#666;font-weight:700;text-transform:uppercase;text-decoration:none;border:2px solid #fff;padding:4px 20px;border-radius:6px;transition:all .3s ease;-webkit-transition:all .3s ease;-moz-transition:all .3s ease}a.klicked-fbia-message-link:hover{background:rgba(255,255,255,0);color:#fff}
        </style>
        <script type="text/javascript">
            var newLink = jQuery(".klicked-fbia-message-link").data("link");
            location.assign(newLink);
        </script>';

        // Update Post
        global $wpdb;
        $wpdb->update($wpdb->posts, array('post_status' => $post->post_status), array('ID' => $post->ID));
        update_post_meta($post->ID, 'klicked_fbia', null);

        // Deliver Message
        wp_die($message, 'Error: Facebook Instant Articles Content Filter');
    }
}
add_action('save_post', 'klicked_mobile_fbia_badwords_update');