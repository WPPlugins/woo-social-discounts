<?php


class Woo_Social_Discounts_Admin {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
                
		$this->version = $version;

	}

	public function enqueue_scripts($hook) {
            
            if(isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == "woo-social-discounts") {
                
                wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js', array( ), $this->version, false );

		wp_enqueue_script( 'woo-social-discounts-admin-js', plugin_dir_url( __FILE__ ) . 'js/woo-social-discounts-admin.js', array( 'jquery' ), $this->version, false );
            }
	}

	public function enqueue_styles() {

            if(isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == "woo-social-discounts") {

                wp_enqueue_style( 'select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css', array(), $this->version, 'all' );
                
                wp_enqueue_style( 'woo-social-discounts-admin-css', plugin_dir_url( __FILE__ ) . 'css/woo-social-discounts-admin.css', array(), $this->version, 'all' );
                
            }
            
	}        

	public function add_plugin_admin_menu() {
            
            add_submenu_page(
                    'woocommerce',
                    __( 'Woo Social Discounts', $this->plugin_name ),
                    __( 'Woo Social Discounts', $this->plugin_name ),
                    'manage_woocommerce',
                    'woo-social-discounts',
                    array( $this, 'display_admin_page' )
            );
                
	}
        
              
	public function register_settings() {
            
            register_setting( 'woo_social_discounts_group', 'woo_social_discounts');
            
            register_setting( 'woo_social_discounts_group', 'woo_social_discounts_allowed_countries');
                
	}
        
	public function display_admin_page() {
        
           global $wpdb;

           $post_table = $wpdb->prefix . 'posts';

           $post_meta_table = $wpdb->prefix . 'postmeta';

           $coupon_objects_array = $wpdb->get_results("SELECT post_title FROM $post_table INNER JOIN $post_meta_table ON $post_table.ID = $post_meta_table.post_id WHERE $post_table.post_type = 'shop_coupon' AND $post_meta_table.meta_key =  'expiry_date' AND DATE( $post_meta_table.meta_value ) > CURRENT_DATE");

           $settings         = get_option( 'woo_social_discounts' );
           
           $woo_social_discounts_allowed_countries = get_option( 'woo_social_discounts_allowed_countries' );
           
           $woo_social_discounts_countries = array(
            'AF' => __( 'Afghanistan', 'woo_social_discounts' ),
            'AX' => __( '&#197;land Islands', 'woo_social_discounts' ),
            'AL' => __( 'Albania', 'woo_social_discounts' ),
            'DZ' => __( 'Algeria', 'woo_social_discounts' ),
            'AD' => __( 'Andorra', 'woo_social_discounts' ),
            'AO' => __( 'Angola', 'woo_social_discounts' ),
            'AI' => __( 'Anguilla', 'woo_social_discounts' ),
            'AQ' => __( 'Antarctica', 'woo_social_discounts' ),
            'AG' => __( 'Antigua and Barbuda', 'woo_social_discounts' ),
            'AR' => __( 'Argentina', 'woo_social_discounts' ),
            'AM' => __( 'Armenia', 'woo_social_discounts' ),
            'AW' => __( 'Aruba', 'woo_social_discounts' ),
            'AU' => __( 'Australia', 'woo_social_discounts' ),
            'AT' => __( 'Austria', 'woo_social_discounts' ),
            'AZ' => __( 'Azerbaijan', 'woo_social_discounts' ),
            'BS' => __( 'Bahamas', 'woo_social_discounts' ),
            'BH' => __( 'Bahrain', 'woo_social_discounts' ),
            'BD' => __( 'Bangladesh', 'woo_social_discounts' ),
            'BB' => __( 'Barbados', 'woo_social_discounts' ),
            'BY' => __( 'Belarus', 'woo_social_discounts' ),
            'BE' => __( 'Belgium', 'woo_social_discounts' ),
            'PW' => __( 'Belau', 'woo_social_discounts' ),
            'BZ' => __( 'Belize', 'woo_social_discounts' ),
            'BJ' => __( 'Benin', 'woo_social_discounts' ),
            'BM' => __( 'Bermuda', 'woo_social_discounts' ),
            'BT' => __( 'Bhutan', 'woo_social_discounts' ),
            'BO' => __( 'Bolivia', 'woo_social_discounts' ),
            'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'woo_social_discounts' ),
            'BA' => __( 'Bosnia and Herzegovina', 'woo_social_discounts' ),
            'BW' => __( 'Botswana', 'woo_social_discounts' ),
            'BV' => __( 'Bouvet Island', 'woo_social_discounts' ),
            'BR' => __( 'Brazil', 'woo_social_discounts' ),
            'IO' => __( 'British Indian Ocean Territory', 'woo_social_discounts' ),
            'VG' => __( 'British Virgin Islands', 'woo_social_discounts' ),
            'BN' => __( 'Brunei', 'woo_social_discounts' ),
            'BG' => __( 'Bulgaria', 'woo_social_discounts' ),
            'BF' => __( 'Burkina Faso', 'woo_social_discounts' ),
            'BI' => __( 'Burundi', 'woo_social_discounts' ),
            'KH' => __( 'Cambodia', 'woo_social_discounts' ),
            'CM' => __( 'Cameroon', 'woo_social_discounts' ),
            'CA' => __( 'Canada', 'woo_social_discounts' ),
            'CV' => __( 'Cape Verde', 'woo_social_discounts' ),
            'KY' => __( 'Cayman Islands', 'woo_social_discounts' ),
            'CF' => __( 'Central African Republic', 'woo_social_discounts' ),
            'TD' => __( 'Chad', 'woo_social_discounts' ),
            'CL' => __( 'Chile', 'woo_social_discounts' ),
            'CN' => __( 'China', 'woo_social_discounts' ),
            'CX' => __( 'Christmas Island', 'woo_social_discounts' ),
            'CC' => __( 'Cocos (Keeling) Islands', 'woo_social_discounts' ),
            'CO' => __( 'Colombia', 'woo_social_discounts' ),
            'KM' => __( 'Comoros', 'woo_social_discounts' ),
            'CG' => __( 'Congo (Brazzaville)', 'woo_social_discounts' ),
            'CD' => __( 'Congo (Kinshasa)', 'woo_social_discounts' ),
            'CK' => __( 'Cook Islands', 'woo_social_discounts' ),
            'CR' => __( 'Costa Rica', 'woo_social_discounts' ),
            'HR' => __( 'Croatia', 'woo_social_discounts' ),
            'CU' => __( 'Cuba', 'woo_social_discounts' ),
            'CW' => __( 'Cura&Ccedil;ao', 'woo_social_discounts' ),
            'CY' => __( 'Cyprus', 'woo_social_discounts' ),
            'CZ' => __( 'Czech Republic', 'woo_social_discounts' ),
            'DK' => __( 'Denmark', 'woo_social_discounts' ),
            'DJ' => __( 'Djibouti', 'woo_social_discounts' ),
            'DM' => __( 'Dominica', 'woo_social_discounts' ),
            'DO' => __( 'Dominican Republic', 'woo_social_discounts' ),
            'EC' => __( 'Ecuador', 'woo_social_discounts' ),
            'EG' => __( 'Egypt', 'woo_social_discounts' ),
            'SV' => __( 'El Salvador', 'woo_social_discounts' ),
            'GQ' => __( 'Equatorial Guinea', 'woo_social_discounts' ),
            'ER' => __( 'Eritrea', 'woo_social_discounts' ),
            'EE' => __( 'Estonia', 'woo_social_discounts' ),
            'ET' => __( 'Ethiopia', 'woo_social_discounts' ),
            'FK' => __( 'Falkland Islands', 'woo_social_discounts' ),
            'FO' => __( 'Faroe Islands', 'woo_social_discounts' ),
            'FJ' => __( 'Fiji', 'woo_social_discounts' ),
            'FI' => __( 'Finland', 'woo_social_discounts' ),
            'FR' => __( 'France', 'woo_social_discounts' ),
            'GF' => __( 'French Guiana', 'woo_social_discounts' ),
            'PF' => __( 'French Polynesia', 'woo_social_discounts' ),
            'TF' => __( 'French Southern Territories', 'woo_social_discounts' ),
            'GA' => __( 'Gabon', 'woo_social_discounts' ),
            'GM' => __( 'Gambia', 'woo_social_discounts' ),
            'GE' => __( 'Georgia', 'woo_social_discounts' ),
            'DE' => __( 'Germany', 'woo_social_discounts' ),
            'GH' => __( 'Ghana', 'woo_social_discounts' ),
            'GI' => __( 'Gibraltar', 'woo_social_discounts' ),
            'GR' => __( 'Greece', 'woo_social_discounts' ),
            'GL' => __( 'Greenland', 'woo_social_discounts' ),
            'GD' => __( 'Grenada', 'woo_social_discounts' ),
            'GP' => __( 'Guadeloupe', 'woo_social_discounts' ),
            'GT' => __( 'Guatemala', 'woo_social_discounts' ),
            'GG' => __( 'Guernsey', 'woo_social_discounts' ),
            'GN' => __( 'Guinea', 'woo_social_discounts' ),
            'GW' => __( 'Guinea-Bissau', 'woo_social_discounts' ),
            'GY' => __( 'Guyana', 'woo_social_discounts' ),
            'HT' => __( 'Haiti', 'woo_social_discounts' ),
            'HM' => __( 'Heard Island and McDonald Islands', 'woo_social_discounts' ),
            'HN' => __( 'Honduras', 'woo_social_discounts' ),
            'HK' => __( 'Hong Kong', 'woo_social_discounts' ),
            'HU' => __( 'Hungary', 'woo_social_discounts' ),
            'IS' => __( 'Iceland', 'woo_social_discounts' ),
            'IN' => __( 'India', 'woo_social_discounts' ),
            'ID' => __( 'Indonesia', 'woo_social_discounts' ),
            'IR' => __( 'Iran', 'woo_social_discounts' ),
            'IQ' => __( 'Iraq', 'woo_social_discounts' ),
            'IE' => __( 'Republic of Ireland', 'woo_social_discounts' ),
            'IM' => __( 'Isle of Man', 'woo_social_discounts' ),
            'IL' => __( 'Israel', 'woo_social_discounts' ),
            'IT' => __( 'Italy', 'woo_social_discounts' ),
            'CI' => __( 'Ivory Coast', 'woo_social_discounts' ),
            'JM' => __( 'Jamaica', 'woo_social_discounts' ),
            'JP' => __( 'Japan', 'woo_social_discounts' ),
            'JE' => __( 'Jersey', 'woo_social_discounts' ),
            'JO' => __( 'Jordan', 'woo_social_discounts' ),
            'KZ' => __( 'Kazakhstan', 'woo_social_discounts' ),
            'KE' => __( 'Kenya', 'woo_social_discounts' ),
            'KI' => __( 'Kiribati', 'woo_social_discounts' ),
            'KW' => __( 'Kuwait', 'woo_social_discounts' ),
            'KG' => __( 'Kyrgyzstan', 'woo_social_discounts' ),
            'LA' => __( 'Laos', 'woo_social_discounts' ),
            'LV' => __( 'Latvia', 'woo_social_discounts' ),
            'LB' => __( 'Lebanon', 'woo_social_discounts' ),
            'LS' => __( 'Lesotho', 'woo_social_discounts' ),
            'LR' => __( 'Liberia', 'woo_social_discounts' ),
            'LY' => __( 'Libya', 'woo_social_discounts' ),
            'LI' => __( 'Liechtenstein', 'woo_social_discounts' ),
            'LT' => __( 'Lithuania', 'woo_social_discounts' ),
            'LU' => __( 'Luxembourg', 'woo_social_discounts' ),
            'MO' => __( 'Macao S.A.R., China', 'woo_social_discounts' ),
            'MK' => __( 'Macedonia', 'woo_social_discounts' ),
            'MG' => __( 'Madagascar', 'woo_social_discounts' ),
            'MW' => __( 'Malawi', 'woo_social_discounts' ),
            'MY' => __( 'Malaysia', 'woo_social_discounts' ),
            'MV' => __( 'Maldives', 'woo_social_discounts' ),
            'ML' => __( 'Mali', 'woo_social_discounts' ),
            'MT' => __( 'Malta', 'woo_social_discounts' ),
            'MH' => __( 'Marshall Islands', 'woo_social_discounts' ),
            'MQ' => __( 'Martinique', 'woo_social_discounts' ),
            'MR' => __( 'Mauritania', 'woo_social_discounts' ),
            'MU' => __( 'Mauritius', 'woo_social_discounts' ),
            'YT' => __( 'Mayotte', 'woo_social_discounts' ),
            'MX' => __( 'Mexico', 'woo_social_discounts' ),
            'FM' => __( 'Micronesia', 'woo_social_discounts' ),
            'MD' => __( 'Moldova', 'woo_social_discounts' ),
            'MC' => __( 'Monaco', 'woo_social_discounts' ),
            'MN' => __( 'Mongolia', 'woo_social_discounts' ),
            'ME' => __( 'Montenegro', 'woo_social_discounts' ),
            'MS' => __( 'Montserrat', 'woo_social_discounts' ),
            'MA' => __( 'Morocco', 'woo_social_discounts' ),
            'MZ' => __( 'Mozambique', 'woo_social_discounts' ),
            'MM' => __( 'Myanmar', 'woo_social_discounts' ),
            'NA' => __( 'Namibia', 'woo_social_discounts' ),
            'NR' => __( 'Nauru', 'woo_social_discounts' ),
            'NP' => __( 'Nepal', 'woo_social_discounts' ),
            'NL' => __( 'Netherlands', 'woo_social_discounts' ),
            'AN' => __( 'Netherlands Antilles', 'woo_social_discounts' ),
            'NC' => __( 'New Caledonia', 'woo_social_discounts' ),
            'NZ' => __( 'New Zealand', 'woo_social_discounts' ),
            'NI' => __( 'Nicaragua', 'woo_social_discounts' ),
            'NE' => __( 'Niger', 'woo_social_discounts' ),
            'NG' => __( 'Nigeria', 'woo_social_discounts' ),
            'NU' => __( 'Niue', 'woo_social_discounts' ),
            'NF' => __( 'Norfolk Island', 'woo_social_discounts' ),
            'KP' => __( 'North Korea', 'woo_social_discounts' ),
            'NO' => __( 'Norway', 'woo_social_discounts' ),
            'OM' => __( 'Oman', 'woo_social_discounts' ),
            'PK' => __( 'Pakistan', 'woo_social_discounts' ),
            'PS' => __( 'Palestinian Territory', 'woo_social_discounts' ),
            'PA' => __( 'Panama', 'woo_social_discounts' ),
            'PG' => __( 'Papua New Guinea', 'woo_social_discounts' ),
            'PY' => __( 'Paraguay', 'woo_social_discounts' ),
            'PE' => __( 'Peru', 'woo_social_discounts' ),
            'PH' => __( 'Philippines', 'woo_social_discounts' ),
            'PN' => __( 'Pitcairn', 'woo_social_discounts' ),
            'PL' => __( 'Poland', 'woo_social_discounts' ),
            'PT' => __( 'Portugal', 'woo_social_discounts' ),
            'QA' => __( 'Qatar', 'woo_social_discounts' ),
            'RE' => __( 'Reunion', 'woo_social_discounts' ),
            'RO' => __( 'Romania', 'woo_social_discounts' ),
            'RU' => __( 'Russia', 'woo_social_discounts' ),
            'RW' => __( 'Rwanda', 'woo_social_discounts' ),
            'BL' => __( 'Saint Barth&eacute;lemy', 'woo_social_discounts' ),
            'SH' => __( 'Saint Helena', 'woo_social_discounts' ),
            'KN' => __( 'Saint Kitts and Nevis', 'woo_social_discounts' ),
            'LC' => __( 'Saint Lucia', 'woo_social_discounts' ),
            'MF' => __( 'Saint Martin (French part)', 'woo_social_discounts' ),
            'SX' => __( 'Saint Martin (Dutch part)', 'woo_social_discounts' ),
            'PM' => __( 'Saint Pierre and Miquelon', 'woo_social_discounts' ),
            'VC' => __( 'Saint Vincent and the Grenadines', 'woo_social_discounts' ),
            'SM' => __( 'San Marino', 'woo_social_discounts' ),
            'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'woo_social_discounts' ),
            'SA' => __( 'Saudi Arabia', 'woo_social_discounts' ),
            'SN' => __( 'Senegal', 'woo_social_discounts' ),
            'RS' => __( 'Serbia', 'woo_social_discounts' ),
            'SC' => __( 'Seychelles', 'woo_social_discounts' ),
            'SL' => __( 'Sierra Leone', 'woo_social_discounts' ),
            'SG' => __( 'Singapore', 'woo_social_discounts' ),
            'SK' => __( 'Slovakia', 'woo_social_discounts' ),
            'SI' => __( 'Slovenia', 'woo_social_discounts' ),
            'SB' => __( 'Solomon Islands', 'woo_social_discounts' ),
            'SO' => __( 'Somalia', 'woo_social_discounts' ),
            'ZA' => __( 'South Africa', 'woo_social_discounts' ),
            'GS' => __( 'South Georgia/Sandwich Islands', 'woo_social_discounts' ),
            'KR' => __( 'South Korea', 'woo_social_discounts' ),
            'SS' => __( 'South Sudan', 'woo_social_discounts' ),
            'ES' => __( 'Spain', 'woo_social_discounts' ),
            'LK' => __( 'Sri Lanka', 'woo_social_discounts' ),
            'SD' => __( 'Sudan', 'woo_social_discounts' ),
            'SR' => __( 'Suriname', 'woo_social_discounts' ),
            'SJ' => __( 'Svalbard and Jan Mayen', 'woo_social_discounts' ),
            'SZ' => __( 'Swaziland', 'woo_social_discounts' ),
            'SE' => __( 'Sweden', 'woo_social_discounts' ),
            'CH' => __( 'Switzerland', 'woo_social_discounts' ),
            'SY' => __( 'Syria', 'woo_social_discounts' ),
            'TW' => __( 'Taiwan', 'woo_social_discounts' ),
            'TJ' => __( 'Tajikistan', 'woo_social_discounts' ),
            'TZ' => __( 'Tanzania', 'woo_social_discounts' ),
            'TH' => __( 'Thailand', 'woo_social_discounts' ),
            'TL' => __( 'Timor-Leste', 'woo_social_discounts' ),
            'TG' => __( 'Togo', 'woo_social_discounts' ),
            'TK' => __( 'Tokelau', 'woo_social_discounts' ),
            'TO' => __( 'Tonga', 'woo_social_discounts' ),
            'TT' => __( 'Trinidad and Tobago', 'woo_social_discounts' ),
            'TN' => __( 'Tunisia', 'woo_social_discounts' ),
            'TR' => __( 'Turkey', 'woo_social_discounts' ),
            'TM' => __( 'Turkmenistan', 'woo_social_discounts' ),
            'TC' => __( 'Turks and Caicos Islands', 'woo_social_discounts' ),
            'TV' => __( 'Tuvalu', 'woo_social_discounts' ),
            'UG' => __( 'Uganda', 'woo_social_discounts' ),
            'UA' => __( 'Ukraine', 'woo_social_discounts' ),
            'AE' => __( 'United Arab Emirates', 'woo_social_discounts' ),
            'GB' => __( 'United Kingdom (UK)', 'woo_social_discounts' ),
            'US' => __( 'United States (US)', 'woo_social_discounts' ),
            'UY' => __( 'Uruguay', 'woo_social_discounts' ),
            'UZ' => __( 'Uzbekistan', 'woo_social_discounts' ),
            'VU' => __( 'Vanuatu', 'woo_social_discounts' ),
            'VA' => __( 'Vatican', 'woo_social_discounts' ),
            'VE' => __( 'Venezuela', 'woo_social_discounts' ),
            'VN' => __( 'Vietnam', 'woo_social_discounts' ),
            'WF' => __( 'Wallis and Futuna', 'woo_social_discounts' ),
            'EH' => __( 'Western Sahara', 'woo_social_discounts' ),
            'WS' => __( 'Western Samoa', 'woo_social_discounts' ),
            'YE' => __( 'Yemen', 'woo_social_discounts' ),
            'ZM' => __( 'Zambia', 'woo_social_discounts' ),
            'ZW' => __( 'Zimbabwe', 'woo_social_discounts' )
    );
           

           include_once 'partials/woo-social-discounts-admin-display.php';

	}
        

	public function plugin_settings_link( $links ) {
            
            $action_links = array(

                    'settings' => '<a href="' . admin_url( 'admin.php?page=woo-social-discounts' ) . '" title="' . esc_attr( __( 'View Settings', 'woo-social-discounts' ) ) . '">' . __( 'Settings', 'woo-social-discounts' ) . '</a>',

            );

            return array_merge( $action_links, $links );
	}
 
        
}
