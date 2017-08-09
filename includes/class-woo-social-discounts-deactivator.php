<?php

/**
 * Fired during plugin deactivation.
 */
class Woo_Social_Discounts_Deactivator {

	public static function deactivate() {
            
            delete_option( 'woo_social_discounts' );

	}

}
