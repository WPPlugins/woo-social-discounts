<?php

/**
 * Fired during plugin activation.
 *
 */
class Woo_Social_Discounts_Activator {

	public static function activate() {
      
            add_option( 'woo_social_discounts', array('message' =>'Share this for a discount',
                                                            'social_shares' => array('facebook'=>true,
                                                                                    'twitter'=>true)) );
            
            add_option( 'woo_social_discounts_allowed_countries', array() );
            
	}

}
