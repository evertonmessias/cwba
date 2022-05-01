<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class Flexible_Checkout_Fields_Settings {

	    /**
	     * Flexible_Checkout_Fields_Settings constructor.
	     *
	     * @param Flexible_Checkout_Fields_Plugin $plugin .
	     */
        public function __construct( $plugin ) {

            $this->plugin = $plugin;

            add_action( 'init', array($this, 'init_polylang') );
            add_action( 'admin_init', array($this, 'init_wpml') );
        }

        function init_polylang() {
        	if ( function_exists( 'pll_register_string' ) ) {
        		$settings = get_option('inspire_checkout_fields_settings', array() );
        		foreach ( $settings as $section ) {
        			if ( is_array( $section ) ) {
        				foreach ( $section as $field ) {
        					if ( isset( $field['label'] ) && $field['label'] != '' ) {
        						pll_register_string( $field['label'], $field['label'], __('Flexible Checkout Fields', 'flexible-checkout-fields' ) );
        					}
        					if ( isset( $field['placeholder'] ) && $field['placeholder'] != '' ) {
        						pll_register_string( $field['placeholder'], $field['placeholder'], __('Flexible Checkout Fields', 'flexible-checkout-fields' ) );
        					}
					        if ( isset( $field['default'] ) && $field['default'] != '' ) {
						        pll_register_string( $field['default'], $field['default'], __('Flexible Checkout Fields', 'flexible-checkout-fields' ) );
					        }
							if ( isset( $field['options'] ) ) {
								foreach ( $field['options'] as $option_data ) {
									pll_register_string( $option_data['value'], $option_data['value'], __('Flexible Checkout Fields', 'flexible-checkout-fields' ) );
								}
							}
        				}
        			}
        		}
        	}
        }

        function init_wpml() {
        	if ( function_exists( 'icl_register_string' ) ) {
        		$icl_language_code = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_bloginfo('language');
        		$settings = get_option('inspire_checkout_fields_settings', array() );
        		foreach ( $settings as $section ) {
        			if ( is_array( $section ) ) {
        				foreach ( $section as $field ) {
        					if ( isset( $field['label'] ) && $field['label'] != '' ) {
        						icl_register_string( 'flexible-checkout-fields', $field['label'], $field['label'], false, $icl_language_code );
        					}
        					if ( isset( $field['placeholder'] ) && $field['placeholder'] != '' ) {
        						icl_register_string( 'flexible-checkout-fields', $field['placeholder'], $field['placeholder'], false, $icl_language_code );
        					}
					        if ( isset( $field['default'] ) && $field['default'] != '' ) {
						        icl_register_string( 'flexible-checkout-fields', $field['default'], $field['default'], false, $icl_language_code );
					        }
							if ( isset( $field['options'] ) ) {
								foreach ( $field['options'] as $option_data ) {
									icl_register_string( $option_data['value'], $option_data['value'], __('Flexible Checkout Fields', 'flexible-checkout-fields' ) );
								}
							}
        				}
        			}
        		}
        	}
        }
    }
