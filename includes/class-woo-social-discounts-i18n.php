<?php

/**
 * Define the internationalization functionality.
 *
 */
    class Woo_Social_Discounts_i18n {

            private $domain;

            public function load_plugin_textdomain() {

                    load_plugin_textdomain(
                            $this->domain,
                            false,
                            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
                    );

            }

            public function set_domain( $domain ) {
                    $this->domain = $domain;
            }

    }
