<?php

class Flexible_Checkout_Fields_Disaplay_Options {

	const HOOK_PRIORITY_LAST = 999999;

	const DISPLAY_ON_ADDRESS = 'display_on_address';
	const DISPLAY_ON_THANK_YOU = 'display_on_thank_you';
	const DISPLAY_ON_ORDER = 'display_on_order';
	const DISPLAY_ON_EMAILS = 'display_on_emails';

	protected $plugin;

	protected $current_address_type = 'shipping';

	protected $in_email_address = false;

	/**
	 * Flexible_Checkout_Fields_Disaplay_Options constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 *
	 */
	protected function hooks() {
		add_filter( 'woocommerce_localisation_address_formats', array( $this, 'woocommerce_localisation_address_formats_filter' ), self::HOOK_PRIORITY_LAST );
		add_filter( 'woocommerce_formatted_address_replacements', array( $this, 'woocommerce_formatted_address_replacements' ), self::HOOK_PRIORITY_LAST, 2 );
		add_filter( 'woocommerce_order_formatted_billing_address', array( $this, 'woocommerce_order_formatted_billing_address' ), self::HOOK_PRIORITY_LAST, 2 );
		add_filter( 'woocommerce_order_formatted_shipping_address', array( $this, 'woocommerce_order_formatted_shipping_address' ), self::HOOK_PRIORITY_LAST, 2 );

		// addresses in my account
		add_filter( 'woocommerce_my_account_my_address_formatted_address', array( $this, 'woocommerce_my_account_my_address_formatted_address' ), 10, 3 );

		add_action( 'woocommerce_billing_fields', array($this, 'woocommerce_billing_fields'), 19999 );
		add_action( 'woocommerce_shipping_fields', array($this, 'woocommerce_shipping_fields'), 19999 );

		add_action( 'woocommerce_email_customer_details', array( $this, 'woocommerce_email_customer_details_start' ), 10 );

		add_action( 'woocommerce_email_customer_details', array( $this, 'woocommerce_email_customer_details_end' ), 10000 );

		// additional fields
		add_action( 'woocommerce_thankyou', array( $this, 'additional_information_fields' ), 75 );
		add_action( 'woocommerce_email_order_meta', array( $this, 'email_additional_information_fields' ), 195 );
		add_action( 'woocommerce_view_order', array( $this, 'additional_information_fields' ), 195 );

		add_action( 'woocommerce_edit_account_form', array( $this, 'woocommerce_edit_account_form' ) );
	}

	public function woocommerce_edit_account_form() {
	}

	public function email_additional_information_fields( $order ) {
		$this->in_email_address = true;
		$this->additional_information_fields( wpdesk_get_order_id( $order ) );
		$this->in_email_address = false;
	}

	/**
	 * Displays additional fields.
	 *
	 * @param int $order_id Order id.
	 */
	public function additional_information_fields( $order_id ) {

		$settings = $this->plugin->getCheckoutFields( $this->plugin->get_settings() );

		$checkout_field_type = $this->plugin->get_fields();

		if ( ! empty( $settings ) && is_array( $settings ) ) {
			$return = array();
			foreach ( $settings as $key => $type ) {
				if ( in_array( $key, array( 'billing', 'shipping' ), true ) ) {
					continue;
				}
				if ( isset( $type ) && is_array( $type ) ) {
					foreach ( $type as $field ) {
						if ( isset( $field['visible'] ) && 0 === intval( $field['visible'] ) && isset( $field['custom_field'] ) && 1 === intval( $field['custom_field'] ) ) {
							$value = wpdesk_get_order_meta( $order_id, '_' . $field['name'], true );
							if ( $this->is_field_displayable( $field ) && '' !== $value ) {
								if ( ! empty( $checkout_field_type[ $field['type'] ]['has_options'] ) ) {
									$options = $field['options'];
									if ( isset( $options[ $value ] ) ) {
										$value = $options[ $value ];
									}
								}
								$value = apply_filters( 'flexible_checkout_fields_print_value', $value, $field );
								if ( '' !== $value ) {
									$return[] = strip_tags( wpdesk__( $field['label'], 'flexible-checkout-fields' ) ) . ': ' . esc_html( $value );
								}
							}
						}
					}
				}
			}
			if ( count( $return ) > 0 ) {
				echo '<div class="inspire_checkout_fields_additional_information">';
				echo '<h3>' . __( 'Additional Information', 'flexible-checkout-fields' ) . '</h3>';
				echo '<p>' . implode( '<br />', $return ) . '</p>';
				echo '</div>';
			}
		}
	}


	public function woocommerce_email_customer_details_start() {
		$this->in_email_address = true;
	}

	public function woocommerce_email_customer_details_end() {
		$this->in_email_address = false;
	}

	public function woocommerce_my_account_my_address_formatted_address( $address, $customer_id, $address_type ) {
		$checkout_field_type = $this->plugin->get_fields();
		$this->current_address_type = $address_type;
		WC()->countries->address_formats = '';
		$cf_fields = $this->getCheckoutFields( array(), $address_type );
		$is_empty_address = $this->check_if_address_is_empty ( $address );
		foreach ( $cf_fields as $field_key => $field ) {
			$fcf_field = new Flexible_Checkout_Fields_Field( $field, $this->plugin);
			if ( !isset( $address[$field['name']] ) ) {
				$val = '';
				if ( $fcf_field->is_custom_field() && $fcf_field->get_display_on_option_show_label() === '1' ) {
					$val .= strip_tags( wpdesk__( $field['label'], 'flexible-checkout-fields' ) ) . ': ';
				}

				$meta_value = get_user_meta( $customer_id, $field_key, true );
				$meta_value = apply_filters( 'flexible_checkout_fields_user_meta_display_value', $meta_value, $field );
				$val       .= $meta_value;
				if ( $is_empty_address && ( $meta_value === '' ) ) {
					$val = '';
				}

				$address[$field['name']] = $val;
				$address[$this->replace_only_first(  $address_type . '_', '', $field['name'] )] = $val;
			}
		}

		return $address;
	}

	public function getCheckoutFields( $fields, $request_type = null ) {
		return $this->plugin->getCheckoutFields( $fields, $request_type );
	}

	/**
	 * Checks if all values in address array are empty.
	 *
	 * @param string[] $address Array keys are field names and values are field values.
	 *
	 * @return bool Status if all values are empty string.
	 */
	private function check_if_address_is_empty( array $address ) {
		foreach ( $address as $field_key => $field_value ) {
			if ( $field_value !== '' ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Append field to address format.
	 *
	 * @param string $format
	 * @param string $field_key
	 * @param array $field
	 *
	 * @return string
	 */
	private function append_field_to_address_format( $format, $field_key, $field ) {
		if ( ( $this->is_thankyou_page() || $this->is_in_email() || $this->is_order_page() )
		     && in_array( $field_key, array( 'billing_phone', 'billing_email' ) )
		) {
			return $format;
		}
		$fcf_field = new Flexible_Checkout_Fields_Field( $field, $this->plugin );
		if ( isset( $field['type'] ) && in_array( $field['type'], array( 'heading', 'info', 'paragraph', 'image' ) ) ) {
			return $format;
		}
		if ( $this->is_field_displayable( $field ) ) {
			if ( $format != '' ) {
				if ( $fcf_field->get_display_on_option_new_line_before() === '1' ) {
					$format .= "\n";
				} elseif ( ! $fcf_field->get_display_comma_before() ) {
					$format .= ' ';
				}
			}
			if ( $fcf_field->get_display_comma_before() ) {
				$format .= ', ';
			}
			$field_name = $fcf_field->get_name_for_address_format();
			$format .= '{' . $this->replace_only_first( $this->current_address_type . '_', '',  $field_name . '}' );
		}

		return $format;
	}

	/**
	 * Localisation address formats - woocommerce filter.
	 *
	 * @param array $formats
	 *
	 * @return array
	 */
	public function woocommerce_localisation_address_formats_filter( $formats ) {
		$fields = $this->getCheckoutFields( array(), $this->current_address_type );
		if ( empty( $fields ) ) {
			return $formats;
		}

		foreach ( $formats as $format_key => $format ) {
			if ( $this->is_edit_address_page()
				 || $this->is_order_page()
				 || $this->is_in_email()
				 || $this->is_thankyou_page()
			) {
				$formats[ $format_key ] = '';
				foreach ( $fields as $field_key => $field ) {
					$formats[ $format_key ] = $this->append_field_to_address_format( $formats[ $format_key ], $field_key, $field );
				}
			}
		}

		return $formats;
	}

	private function is_field_displayable( $field ) {
		$displayable = true;
		$fcf_field = new Flexible_Checkout_Fields_Field( $field, $this->plugin );
		if ( $this->is_edit_address_page() ) {
			$displayable = !isset( $field[self::DISPLAY_ON_ADDRESS] ) || $field[self::DISPLAY_ON_ADDRESS] == '1';
			if ( $fcf_field->is_field_excluded_for_user() ) {
				$displayable = false;
			}
		}
		if ( $this->is_order_page() ) {
			$displayable = !isset( $field[self::DISPLAY_ON_ORDER] ) || $field[self::DISPLAY_ON_ORDER] == '1';
		}
		if ( $this->is_in_email() ) {
			$displayable = !isset( $field[self::DISPLAY_ON_EMAILS] ) || $field[self::DISPLAY_ON_EMAILS] == '1';
		}
		if ( $this->is_thankyou_page() ) {
			$displayable = !isset( $field[self::DISPLAY_ON_THANK_YOU] ) || $field[self::DISPLAY_ON_THANK_YOU] == '1';
		}
		return $displayable;
	}

	public function is_admin_edit_order() {
		$admin_edit_order = false;
		if ( is_admin() ) {
			$admin_edit_order = true;
		}
		return $admin_edit_order;
	}

	public function is_edit_address_page() {
		global $wp;
		$edit_address_page = false;
		if ( is_account_page() ) {
			if ( isset( $wp->query_vars['edit-address'] ) ) {
				$edit_address_page = true;
			}
		}
		return $edit_address_page;
	}

	public function is_order_page() {
		global $wp;
		$order_page = false;
		if ( is_account_page() ) {
			if ( isset( $wp->query_vars['view-order'] ) ) {
				$order_page = true;
			}
		}
		return $order_page;
	}

	public function is_in_email() {
		$in_email = false;
		if ( $this->in_email_address ) {
			$in_email = true;
		}
		return $in_email;
	}

	public function is_thankyou_page() {
		global $wp;
		$thankyou_page = false;
		if ( is_checkout() ) {
			if ( isset( $wp->query_vars['order-received'] ) ) {
				$thankyou_page = true;
			}
		}
		return $thankyou_page;
	}

	public function woocommerce_formatted_address_replacements( $fields, $args ) {
		foreach ( $args as $arg_key => $arg ) {
			if ( !isset( $fields['{' . $arg_key . '}'] ) ) {
				$fields['{' . $arg_key . '}'] = $arg;
			}
		}

		return $fields;
	}

	public function woocommerce_order_formatted_billing_address( $fields, $order ) {
		$this->current_address_type = 'billing';
		WC()->countries->address_formats = '';
		return $this->woocommerce_order_formatted_address( $fields, $order, 'billing' );
	}

	/**
	 * @param array $fields
	 * @param WC_Order $order
	 * @param string $address_type
	 *
	 * @return mixed
	 */
	public function woocommerce_order_formatted_address( $fields, $order, $address_type ) {

		$cf_fields = $this->getCheckoutFields( array(), $address_type );
		$checkout_field_type = $this->plugin->get_fields();

		foreach ( $cf_fields as $field_key => $field ) {
			$val = wpdesk_get_order_meta( $order, '_' . $field_key, true );
			if ( empty( $val ) && isset( $fields[ $field_key ] ) ) {
				$val = $fields[ $field_key ];
			}

			$fcf_field = new Flexible_Checkout_Fields_Field( $field, $this->plugin );
			if ( (isset( $field['custom_field'] ) && $field['custom_field'] == '1')) {
				$val = '';
				if ( $fcf_field->is_custom_field() && $fcf_field->get_display_on_option_show_label() === '1' ) {
					$val = strip_tags( wpdesk__( $field['label'], 'flexible-checkout-fields' ) ) . ': ';
				}

				$meta_value = wpdesk_get_order_meta( $order, '_' . $field_key, true );
				$meta_value = apply_filters( 'flexible_checkout_fields_print_value', $meta_value, $field );
				$val .= $meta_value;
			}

			$val = $this->flexible_invoices_ask_field_integration($val, $field, $field_key, $fields);
			$val = wp_kses_post( $val );

			$fields[$field['name']] = $val;
			$fields[$this->replace_only_first(  $address_type . '_', '', $field['name'] )] = $val;
		}

		return $fields;
	}

	/**
	 * Similar to str_replace but replaces only the first occurrence.
	 *
	 * @param string $needle search for it.
	 * @param string $replace change the needle to this value.
	 * @param string $haystack here we are searching
	 *
	 * @return string
	 */
	private function replace_only_first($needle, $replace, $haystack) {
		$pos = strpos($haystack, $needle);
		if ($pos !== false) {
			return substr_replace($haystack, $replace, $pos, strlen($needle));
		}
		return $haystack;
	}

	/**
	 * Return value for invoice ask field prepared by FI plugin. If can't then fallback.
	 *
	 * @param string $val Prepared by FCF field value.
	 * @param array $field FCF field def.
	 * @param string $field_key Field key that is currently processed. Needed to check if val should be replaced.
	 * @param array $fields Prepared by WC field values
	 *
	 * @return string New field value
	 */
	private function flexible_invoices_ask_field_integration( $val, $field, $field_key, $fields ) {
		if ( apply_filters( 'flexible_checkout_fields_invoices_integration_enabled', true ) ) {

			// FI ask field integration
			if ( $field_key === 'invoice_ask' && ! empty( $fields['invoice_ask_field'] ) ) {
				return $fields['invoice_ask_field'];
			}

			// wFirma/Fakturownia/iFirma/inFakt ask field integration
			$supported_ask_fields = array(
				'billing_faktura',
				'billing_invoice',
				'billing_rachunek'
			);
			if ( in_array( $field_key, $supported_ask_fields, true ) ) {
				$wc_meta_key_definitions = apply_filters( 'woocommerce_customer_meta_fields', [] );

				$label = strip_tags( wpdesk__( $field['label'], 'flexible-checkout-fields' ) );

				// original plugin is probably(?) disabled if the field is not accessible
				if ( isset( $wc_meta_key_definitions[ $this->current_address_type ]['fields'][ $field_key ] ) ) {
					$wc_field_def = $wc_meta_key_definitions[ $this->current_address_type ]['fields'][ $field_key ];

					// if field exists and is defined as select we can use this data. If not then better do not touch as it's probably optional checkbox
					if ( isset( $wc_field_def['options'] ) ) {
						$select_options = $wc_meta_key_definitions[ $this->current_address_type ]['fields'][ $field_key ]['options'];
						$option_val     = isset( $select_options[ $val ] ) ? $select_options[ $val ] : '';

						return $label . ': ' . $option_val;
					} elseif ( (int) $val === 1 ) {
						return $label;
					}
				}
			}
		}

		return $val;
	}

	/**
	 * Mainly injects FCF data values into WC formatted shipping address.
	 * Also changes current_address_type indicator and do some shady stuff to WC()->countries.
	 *
	 * @param array|string $fields Fields can be string when shipment is disabled
	 * @param WC_Order $order
	 *
	 * @return array|string
	 */
	public function woocommerce_order_formatted_shipping_address( $fields, $order ) {
		$this->current_address_type = 'shipping';
		WC()->countries->address_formats = '';
		if ( ! is_array( $fields ) ) {
			return $fields;
		}

		return $this->woocommerce_order_formatted_address( $fields, $order, 'shipping' );
	}

	public function woocommerce_billing_fields( $fields ) {
		return $this->woocommerce_fields( $fields, 'billing' );
	}

	public function woocommerce_shipping_fields( $fields ) {
		return $this->woocommerce_fields( $fields, 'shipping' );
	}

	protected function woocommerce_fields( $fields, $section ) {
		global $wp;
		$cf_fields = $this->getCheckoutFields( array(), $section );
		$edit_address_page = false;
		if ( is_account_page() ) {
			if ( isset( $wp->query_vars['edit-address'] ) ) {
				$edit_address_page = true;
			}
		}
		foreach ( $cf_fields as $cf_field_key => $cf_field ) {
			$remove_field = false;
			if ( $edit_address_page ) {
				$remove_field = true;
				if ( !isset( $cf_field[self::DISPLAY_ON_ADDRESS] ) || $cf_field[self::DISPLAY_ON_ADDRESS] == '1' ) {
					$remove_field = false;
				}
			}
			if ( $remove_field ) {
				unset( $fields[$cf_field_key] );
			}
		}
		return $fields;
	}

}
