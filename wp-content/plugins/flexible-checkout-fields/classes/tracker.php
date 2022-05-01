<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPDesk_Flexible_Checkout_Fields_Tracker' ) ) {
	class WPDesk_Flexible_Checkout_Fields_Tracker {

		public static $script_version = '11';

		public function __construct() {
			$this->hooks();
		}

		public function hooks() {
			add_filter( 'wpdesk_tracker_data', array( $this, 'wpdesk_tracker_data' ), 11 );
			add_filter( 'wpdesk_tracker_notice_screens', array( $this, 'wpdesk_tracker_notice_screens' ) );

			add_filter( 'plugin_action_links_flexible-checkout-fields/flexible-checkout-fields.php', array( $this, 'plugin_action_links' ) );
			add_action( 'activated_plugin', array( $this, 'activated_plugin' ), 10, 2 );
		}

		public function wpdesk_tracker_data( $data ) {
			$sections = array(
				'billing',
				'shipping',
				'order',
				'before_customer_details',
				'after_customer_details',
				'before_checkout_billing_form',
				'after_checkout_billing_form',
				'before_checkout_shipping_form',
				'after_checkout_shipping_form',
				'before_checkout_registration_form',
				'after_checkout_registration_form',
				'before_order_notes',
				'after_order_notes',
				'review_order_before_submit',
				'review_order_after_submit',
			);
			$settings_fields = get_option('inspire_checkout_fields_settings', array() );
			if ( ! is_array( $settings_fields ) ) {
				$settings_fields = array();
			}

			$plugin_data = [
				'sections'     => $this->get_sections_data( $sections, $settings_fields ),
				'fields_names' => $this->get_fields_names( $settings_fields ),
				'options'      => array(
					'css_disable' => get_option( 'inspire_checkout_fields_css_disable', '0' )
				),
				'pro_version'  => array(
					'is_active'    => is_flexible_checkout_fields_pro_active() ? '1' : '0',
					'is_activated' => ( get_option( 'api_flexible-checkout-fields-pro_activated', '' ) === 'Activated' ) ? '1' : '0',
				),
			];

			$data['flexible_checkout_fields'] = $plugin_data;

			return $data;
		}

		private function get_fields_names( $settings_fields ) {
			$items = array();
			foreach ( $settings_fields as $section_key => $fields ) {
				foreach ( $fields as $field_name => $field ) {
					$name = str_replace( $section_key . '_', '', $field_name );
					if ( !isset( $items[ $name ] ) ) {
						$items[ $name ] = 0;
					}
					$items[ $name ]++;
				}
			}
			return $items;
		}

		private function get_sections_data( $sections, $settings_fields ) {
			$settings_sections = get_option('inspire_checkout_fields_section_settings', array() );
			if ( ! is_array( $settings_sections ) ) {
				$settings_sections = array();
			}
			$default_data = array(
				'enabled'      => 0,
				'has_title'    => 0,
				'has_css'      => 0,
				'fields'       => array(),
				'fields_count' => 0,
			);

			$data = array();
			foreach ( $sections as $section ) {
				$data[$section] = $default_data;
				if ( in_array( $section, array( 'billing', 'shipping', 'order' ) )
					|| get_option( 'inspire_checkout_fields_'  . $section, '0' ) ) {
					$data[$section]['enabled'] = '1';
				}
				if ( isset( $settings_sections[ $section ] ) && ! empty( $settings_sections[ $section ]['section_title'] ) ) {
					$data[$section]['has_title'] = '1';
				}
				if ( isset( $settings_sections[ $section ] ) && ! empty( $settings_sections[ $section ]['section_css'] ) ) {
					$data[$section]['has_css'] = '1';
				}
				$data[$section]['fields'] = $this->get_fields_data( $section, $settings_fields );
				if ( isset( $settings_fields[ $section ] ) ) {
					$data[$section]['fields_count'] = count( $settings_fields[ $section ] );
				}
			}

			return $data;
		}

		private function get_fields_data( $section, $settings ) {
			if ( ! isset( $settings[ $section ] ) ) {
				return array();
			}
			$default_data = array(
				'count'             => 0,
				'enabled'           => 0,
				'required'          => 0,
				'validation'        => array(),
				'default_value'     => 0,
				'placeholder'       => 0,
				'display_on'        => array(
					'thank_you'              => 0,
					'on_address'             => 0,
					'on_order'               => 0,
					'on_emails'              => 0,
					'option_new_line_before' => 0,
					'option_show_label'      => 0,
				),
				'conditional_logic' => array(),
				'pricing'           => array(
					'enabled'     => 0,
					'types'       => array(),
					'values'      => array(),
					'tax_classes' => array(),
				),
			);

			$data = array();
			foreach ( $settings[ $section ] as $field ) {
				$field_type = ( isset( $field['type'] ) ) ? $field['type'] : '_null_';

				if ( ! isset( $data[ $field_type ] ) ) {
					$data[ $field_type ] = $default_data;
				}
				$data[ $field_type ]['count']++;
				if ( isset( $field['visible'] ) && ! $field['visible'] ) {
					$data[ $field_type ]['enabled']++;
				}
				if ( isset( $field['required'] ) && $field['required'] ) {
					$data[ $field_type ]['required']++;
				}
				if ( isset( $field['validation'] ) && $field['validation'] ) {
					if ( ! isset( $data[ $field_type ]['validation'][ $field['validation'] ] ) ) {
						$data[ $field_type ]['validation'][ $field['validation'] ] = 0;
					}
					$data[ $field_type ]['validation'][ $field['validation'] ]++;
				}
				if ( isset( $field['default'] ) && $field['default'] ) {
					$data[ $field_type ]['default_value']++;
				}
				if ( isset( $field['placeholder'] ) && $field['placeholder'] ) {
					$data[ $field_type ]['placeholder']++;
				}
				if ( isset( $field['display_on_thank_you'] ) && $field['display_on_thank_you'] ) {
					$data[ $field_type ]['display_on']['thank_you']++;
				}
				if ( isset( $field['display_on_address'] ) && $field['display_on_address'] ) {
					$data[ $field_type ]['display_on']['on_address']++;
				}
				if ( isset( $field['display_on_order'] ) && $field['display_on_order'] ) {
					$data[ $field_type ]['display_on']['on_order']++;
				}
				if ( isset( $field['display_on_emails'] ) && $field['display_on_emails'] ) {
					$data[ $field_type ]['display_on']['on_emails']++;
				}
				if ( isset( $field['display_on_option_new_line_before'] ) && $field['display_on_option_new_line_before'] ) {
					$data[ $field_type ]['display_on']['option_new_line_before']++;
				}
				if ( isset( $field['display_on_option_show_label'] ) && $field['display_on_option_show_label'] ) {
					$data[ $field_type ]['display_on']['option_show_label']++;
				}
				if ( isset( $field['pricing_enabled'] ) && $field['pricing_enabled'] ) {
					$data[ $field_type ]['pricing']['enabled']++;
				}
				if ( isset( $field['pricing_values'] ) && $field['pricing_values'] ) {
					foreach ( $field['pricing_values'] as $pricing_value ) {
						if ( ! isset( $data[ $field_type ]['pricing']['types'][ $pricing_value['type'] ] ) ) {
							$data[ $field_type ]['pricing']['types'][ $pricing_value['type'] ] = 0;
						}
						$data[ $field_type ]['pricing']['types'][ $pricing_value['type'] ]++;
					}
					foreach ( $field['pricing_values'] as $pricing_value ) {
						if ( ! isset( $data[ $field_type ]['pricing']['values'][ $pricing_value['value'] ] ) ) {
							$data[ $field_type ]['pricing']['values'][ $pricing_value['value'] ] = 0;
						}
						$data[ $field_type ]['pricing']['values'][ $pricing_value['value'] ]++;
					}
					foreach ( $field['pricing_values'] as $pricing_value ) {
						if ( ! isset( $data[ $field_type ]['pricing']['tax_classes'][ $pricing_value['tax_class'] ] ) ) {
							$data[ $field_type ]['pricing']['tax_classes'][ $pricing_value['tax_class'] ] = 0;
						}
						$data[ $field_type ]['pricing']['tax_classes'][ $pricing_value['tax_class'] ]++;
					}
				}
				$data[ $field_type ]['conditional_logic'] = $this->get_conditional_logic_data(
					$field,
					$data[ $field_type ]['conditional_logic']
				);
			}

			return $data;
		}

		private function get_conditional_logic_data( $field, $current_data ) {
			$default_data = array(
				'enabled'        => 0,
				'action'         => array(),
				'operator'       => array(),
				'rule_options'   => array(),
				'rule_operators' => array(),
			);

			$data = ( $current_data )
				? $current_data
				: array(
					'products' => $default_data,
					'fields'   => $default_data,
					'shipping' => $default_data,
				)
			;

			if ( isset( $field['conditional_logic'] ) && $field['conditional_logic'] ) {
				$data['products']['enabled']++;
			}
			if ( isset( $field['conditional_logic_action'] ) && $field['conditional_logic_action'] ) {
				if ( ! isset( $data['products']['action'][ $field['conditional_logic_action'] ] ) ) {
					$data['products']['action'][ $field['conditional_logic_action'] ] = 0;
				}
				$data['products']['action'][ $field['conditional_logic_action'] ]++;
			}
			if ( isset( $field['conditional_logic_operator'] ) && $field['conditional_logic_operator'] ) {
				if ( ! isset( $data['products']['operator'][ $field['conditional_logic_operator'] ] ) ) {
					$data['products']['operator'][ $field['conditional_logic_operator'] ] = 0;
				}
				$data['products']['operator'][ $field['conditional_logic_operator'] ]++;
			}
			if ( isset( $field['conditional_logic_rules'] ) && $field['conditional_logic_rules'] ) {
				foreach ( $field['conditional_logic_rules'] as $rule ) {
					if ( ! isset( $data['products']['rule_options'][ $rule['condition'] ] ) ) {
						$data['products']['rule_options'][ $rule['condition'] ] = 0;
					}
					$data['products']['rule_options'][ $rule['condition'] ]++;
					if ( ! isset( $data['products']['rule_operators'][ $rule['what'] ] ) ) {
						$data['products']['rule_operators'][ $rule['what'] ] = 0;
					}
					$data['products']['rule_operators'][ $rule['what'] ]++;
				}
			}

			if ( isset( $field['conditional_logic_fields'] ) && $field['conditional_logic_fields'] ) {
				$data['fields']['enabled']++;
			}
			if ( isset( $field['conditional_logic_fields_action'] ) && $field['conditional_logic_fields_action'] ) {
				if ( ! isset( $data['fields']['action'][ $field['conditional_logic_fields_action'] ] ) ) {
					$data['fields']['action'][ $field['conditional_logic_fields_action'] ] = 0;
				}
				$data['fields']['action'][ $field['conditional_logic_fields_action'] ]++;
			}
			if ( isset( $field['conditional_logic_fields_operator'] ) && $field['conditional_logic_fields_operator'] ) {
				if ( ! isset( $data['fields']['operator'][ $field['conditional_logic_fields_operator'] ] ) ) {
					$data['fields']['operator'][ $field['conditional_logic_fields_operator'] ] = 0;
				}
				$data['fields']['operator'][ $field['conditional_logic_fields_operator'] ]++;
			}
			if ( isset( $field['conditional_logic_fields_rules'] ) && $field['conditional_logic_fields_rules'] ) {
				foreach ( $field['conditional_logic_fields_rules'] as $rule ) {
					if ( ! isset( $data['fields']['rule_operators'][ $rule['condition'] ] ) ) {
						$data['fields']['rule_operators'][ $rule['condition'] ] = 0;
					}
					$data['fields']['rule_operators'][ $rule['condition'] ]++;
				}
			}

			if ( isset( $field['conditional_logic_shipping_fields'] ) && $field['conditional_logic_shipping_fields'] ) {
				$data['shipping']['enabled']++;
			}
			if ( isset( $field['conditional_logic_shipping_fields_action'] ) && $field['conditional_logic_shipping_fields_action'] ) {
				if ( ! isset( $data['shipping']['action'][ $field['conditional_logic_shipping_fields_action'] ] ) ) {
					$data['shipping']['action'][ $field['conditional_logic_shipping_fields_action'] ] = 0;
				}
				$data['shipping']['action'][ $field['conditional_logic_shipping_fields_action'] ]++;
			}
			if ( isset( $field['conditional_logic_shipping_fields_operator'] ) && $field['conditional_logic_shipping_fields_operator'] ) {
				if ( ! isset( $data['shipping']['operator'][ $field['conditional_logic_shipping_fields_operator'] ] ) ) {
					$data['shipping']['operator'][ $field['conditional_logic_shipping_fields_operator'] ] = 0;
				}
				$data['shipping']['operator'][ $field['conditional_logic_shipping_fields_operator'] ]++;
			}

			return $data;
		}

		public function wpdesk_tracker_notice_screens( $screens ) {
			$current_screen = get_current_screen();
			if ( $current_screen->id == 'woocommerce_page_inspire_checkout_fields_settings' ) {
				$screens[] = $current_screen->id;
			}
			return $screens;
		}

		public function plugin_action_links( $links ) {
			if ( !wpdesk_tracker_enabled() || apply_filters( 'wpdesk_tracker_do_not_ask', false ) ) {
				return $links;
			}
			$options = get_option('wpdesk_helper_options', array() );
			if ( !is_array( $options )) {
				$options = array();
			}
			if ( empty( $options['wpdesk_tracker_agree'] ) ) {
				$options['wpdesk_tracker_agree'] = '0';
			}
			$plugin_links = array();
			if ( $options['wpdesk_tracker_agree'] == '0' ) {
				$opt_in_link = admin_url( 'admin.php?page=wpdesk_tracker&plugin=flexible-checkout-fields/flexible-checkout-fields.php' );
				$plugin_links[] = '<a href="' . $opt_in_link . '">' . __( 'Opt-in', 'flexible-checkout-fields' ) . '</a>';
			}
			else {
				$opt_in_link = admin_url( 'plugins.php?wpdesk_tracker_opt_out=1&plugin=flexible-checkout-fields/flexible-checkout-fields.php' );
				$plugin_links[] = '<a href="' . $opt_in_link . '">' . __( 'Opt-out', 'flexible-checkout-fields' ) . '</a>';
			}
			return array_merge( $plugin_links, $links );
		}

		public function activated_plugin( $plugin, $network_wide ) {
			if ( $network_wide ) {
				return;
			}
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				return;
			}
			if ( !wpdesk_tracker_enabled() ) {
				return;
			}
			if ( $plugin == 'flexible-checkout-fields/flexible-checkout-fields.php' ) {
				$options = get_option('wpdesk_helper_options', array() );

				if ( empty( $options ) ) {
					$options = array();
				}
				if ( empty( $options['wpdesk_tracker_agree'] ) ) {
					$options['wpdesk_tracker_agree'] = '0';
				}
				$wpdesk_tracker_skip_plugin = get_option( 'wpdesk_tracker_skip_flexible_checkout_fields', '0' );
				if ( $options['wpdesk_tracker_agree'] == '0' && $wpdesk_tracker_skip_plugin == '0' ) {
					update_option( 'wpdesk_tracker_notice', '1' );
					update_option( 'wpdesk_tracker_skip_flexible_checkout_fields', '1' );
					if ( !apply_filters( 'wpdesk_tracker_do_not_ask', false ) ) {
						wp_redirect( admin_url( 'admin.php?page=wpdesk_tracker&plugin=flexible-checkout-fields/flexible-checkout-fields.php' ) );
						exit;
					}
				}
			}
		}

	}

}
