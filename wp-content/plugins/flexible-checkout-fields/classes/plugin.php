<?php

use WPDesk\FCF\Free\Field\Type\FileType;
use WPDesk\FCF\Free\Field\Type\MultiCheckboxType;
use WPDesk\FCF\Free\Field\Type\MultiSelectType;
use WPDesk\FCF\Free\Field\Type\TextareaType;
use WPDesk\FCF\Free\Plugin as PluginFree;

/**
 * Class Plugin
 *
 * @package WPDesk\WooCommerceFakturownia
 */
class Flexible_Checkout_Fields_Plugin extends \FcfVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin {

	/** @see validate_checkout method https://github.com/woocommerce/woocommerce/blob/master/includes/class-wc-checkout.php#L719 */
	const FIELDS_REQUIREMENT_CONTROLLED_BY_WOOCOMMERCE = array(
		'billing_country',
		'shipping_country',
		'billing_state',
		'shipping_state',
		'billing_postcode',
		'shipping_postcode',
	);

	/**
	 * Scripts version.
	 *
	 * @var string
	 */
	private $scripts_version = FLEXIBLE_CHECKOUT_FIELDS_VERSION . '.19';

	protected $fields = array();

	public $sections = array();

	public $all_sections = array();

	public $page_size = array();

	public $field_validation;

	/**
	 * Plugin path.
	 *
	 * @var string
	 */
	private $plugin_path;

	/**
	 * Plugin namespaces
	 *
	 * Fot backward compatibility
	 *
	 * @var string
	 */
	public $plugin_namespace = 'inspire_checkout_fields';

	/**
	 * Instance of new version main class of plugin.
	 *
	 * @var PluginFree
	 */
	private $plugin_free;


	/**
	 * Plugin constructor.
	 *
	 * @param \WPDesk_Plugin_Info $plugin_info Plugin info.
	 */
	public function __construct( \FcfVendor\WPDesk_Plugin_Info $plugin_info ) {
		parent::__construct( $plugin_info );
		$this->plugin_info = $plugin_info;
		$this->plugin_free = new PluginFree( $plugin_info, $this );
	}

	/**
	 * Init base variables for plugin
	 */
	public function init_base_variables() {
		$this->plugin_url          = $this->plugin_info->get_plugin_url();
		$this->plugin_path         = $this->plugin_info->get_plugin_dir();
		$this->template_path       = $this->plugin_info->get_text_domain();
		$this->settings_url        = admin_url( 'admin.php?page=wc-settings&tab=integration&section=integration-fakturownia' );
		$this->default_view_args   = [ 'plugin_url' => $this->get_plugin_url() ];
		$this->plugin_has_settings = false;
		$this->plugin_namespace    = 'inspire_checkout_fields';
	}

	/**
	 * Init.
	 */
	public function init() {
		$this->plugin_free->init();
		$this->init_base_variables();
		$this->load_dependencies();
		$this->hooks();
	}

	/**
	 * Load dependencies.
	 */
	private function load_dependencies() {
		new WPDesk_Flexible_Checkout_Fields_Tracker();
		require_once __DIR__ . '/settings.php';
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		$this->plugin_free->hooks();
		parent::hooks();

		$this->settings = new Flexible_Checkout_Fields_Settings( $this, self::FIELDS_REQUIREMENT_CONTROLLED_BY_WOOCOMMERCE );

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ), 100 );

		add_action( 'woocommerce_checkout_fields', array( $this, 'changeCheckoutFields' ), 9999 );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'updateCheckoutFields' ), 9, 2 );

		add_action( 'woocommerce_admin_order_data_after_billing_address', array(
			$this,
			'addCustomBillingFieldsToAdmin'
		) );
		add_action( 'woocommerce_admin_order_data_after_shipping_address', array(
			$this,
			'addCustomShippingFieldsToAdmin'
		) );
		add_action( 'woocommerce_admin_order_data_after_shipping_address', array(
			$this,
			'addCustomOrderFieldsToAdmin'
		) );

		add_action( 'woocommerce_billing_fields', array( $this, 'addCustomFieldsBillingFields' ), 9999 );
		add_action( 'woocommerce_shipping_fields', array( $this, 'addCustomFieldsShippingFields' ), 9999 );
		add_action( 'woocommerce_order_fields', array( $this, 'addCustomFieldsOrderFields' ), 9999 );


		add_action( 'woocommerce_before_checkout_form', array( $this, 'woocommerce_before_checkout_form' ), 10 );
		add_action( 'woocommerce_before_edit_address_form_shipping', array(
			$this,
			'woocommerce_before_checkout_form'
		), 10 );
		add_action( 'woocommerce_before_edit_address_form_billing', array(
			$this,
			'woocommerce_before_checkout_form'
		), 10 );

		add_filter( 'flexible_chekout_fields_fields', array( $this, 'getCheckoutFields' ), 10, 2 );

		add_action( 'woocommerce_default_address_fields', array( $this, 'woocommerce_default_address_fields' ), 9999 );
		add_filter( 'woocommerce_get_country_locale', array( $this, 'woocommerce_get_country_locale' ), 9999 );
		add_filter( 'woocommerce_get_country_locale_base', array( $this, 'woocommerce_get_country_locale_base' ), 9999 );

		add_action( 'woocommerce_get_country_locale_default', array( $this, 'woocommerce_get_country_locale_default' ), 11 );

		add_filter( 'woocommerce_screen_ids', array( $this, 'add_woocommerce_screen_ids' ) );

		new Flexible_Checkout_Fields_Disaplay_Options( $this );

		$user_meta = new Flexible_Checkout_Fields_User_Meta( $this );

		$user_profile = new Flexible_Checkout_Fields_User_Profile( $this, $user_meta );
		$user_profile->hooks();

		$user_meta = new Flexible_Checkout_Fields_User_Meta_Checkout( $this, $user_meta );
		$user_meta->hooks();

		$this->field_validation = new Flexible_Checkout_Fields_Field_Validation( $this );
		$this->field_validation->hooks();

		$my_account_fields_processor = new Flexible_Checkout_Fields_Myaccount_Field_Processor( $this );
		$my_account_fields_processor->hooks();

		$my_account_edit_address = new Flexible_Checkout_Fields_Myaccount_Edit_Address( $this );
		$my_account_edit_address->hooks();

		$plugin = $this;
		add_filter( 'flexible_checkout_fields', static function() use( $plugin ) {
			return $plugin;
		});
	}

	/**
	 * Get plugin path.
	 *
	 * @return string
	 */
	public function get_plugin_path() {
		return $this->plugin_path;
	}


	/**
	 * Load plugin textdomain
	 */
	public function load_plugin_text_domain() {
		load_plugin_textdomain( 'wpdesk-plugin', false, $this->get_text_domain() . '/classes/wpdesk/lang/' );
		load_plugin_textdomain( $this->get_text_domain(), false, $this->get_text_domain() . '/lang/' );
	}

	public function plugins_loaded() {
		$this->init_fields();
		//do użycia dla pola miasto, kod pocztowy i stan
		$this->init_sections();
	}

	/**
	 * Get setting value.
	 *
	 * @param string $name Setting name.
	 * @param mixed $default Default setting value.
	 *
	 * @return mixed|void
	 */
	public function get_setting_value( $name, $default = null ) {
		return get_option( $this->get_namespace() . '_' . $name, $default );
	}

	/**
	 * Change params used by js locale woocommerce/assets/js/frontend/address-i18n.js so it would not overwrite backend settings.
	 *
	 * This is a locale for default country.
	 *
	 * @param array $base Local base.
	 *
	 * @return array
	 */
	public function woocommerce_get_country_locale_base( $base ) {
		$settings = $this->get_settings();

		foreach ( $base as $key => $field ) {
			unset( $base[ $key ]['placeholder'] );
			unset( $base[ $key ]['label'] );
			if ( version_compare( WC()->version, '4.4.1', '>=' ) ) {
				unset( $base[ $key ]['class'] );
			}

			// field is force-required for given locale when FCF have shipping or billing field required
			$shipping_key = 'shipping_' . $key;
			$billing_key  = 'billing_' . $key;
			if ( ( isset( $settings['shipping'][ $shipping_key ] ) && $settings['shipping'][ $shipping_key ]['required'] )
			     || ( isset( $settings['billing'][ $billing_key ] ) && $settings['billing'][ $billing_key ]['required'] ) ) {
				$base [ $key ]['required'] = true;
			}
		}

		return $base;
	}

	/**
	 * Change params used by js locale woocommerce/assets/js/frontend/address-i18n.js so it would not overwrite backend settings
	 *
	 * @param array $locale Table of field settings per locale
	 *
	 * @return array
	 */
	public function woocommerce_get_country_locale( $locale ) {
		if ( is_checkout() || is_account_page() ) {
			foreach ( $locale as $country => $fields ) {
				foreach ( $fields as $field => &$settings ) {
					unset( $locale[ $country ][ $field ]['priority'] );
					unset( $locale[ $country ][ $field ]['label'] );
					unset( $locale[ $country ][ $field ]['placeholder'] );
				}
			}
		}

		return $locale;
	}

	/**
	 * Remove priority from default address field
	 *
	 * @param array $fields Fields.
	 *
	 * @return array
	 */
	public function woocommerce_default_address_fields( $fields ) {
		if ( is_checkout() || is_account_page() ) {
			foreach ( $fields as $key => $field ) {
				unset( $fields[ $key ]['priority'] );
			}
		}

		return $fields;
	}

	/**
	 * Init sections.
	 */
	public function init_sections() {
		$sections = array(
			'billing'  => array(
				'section'        => 'billing',
				'tab'            => 'fields_billing',
				'tab_title'      => __( 'Billing', 'flexible-checkout-fields' ),
				'custom_section' => false,
				'user_meta'      => true,
			),
			'shipping' => array(
				'section'        => 'shipping',
				'tab'            => 'fields_shipping',
				'tab_title'      => __( 'Shipping', 'flexible-checkout-fields' ),
				'custom_section' => false,
				'user_meta'      => true,
			),
			'order'    => array(
				'section'        => 'order',
				'tab'            => 'fields_order',
				'tab_title'      => __( 'Order', 'flexible-checkout-fields' ),
				'custom_section' => false,
				'user_meta'      => false,
			),
		);

		$all_sections = unserialize( serialize( $sections ) );

		$this->sections = apply_filters( 'flexible_checkout_fields_sections', $sections );

		$this->all_sections = apply_filters( 'flexible_checkout_fields_all_sections', $all_sections );
	}

	private function init_fields() {
		$field_types = apply_filters( 'flexible_checkout_fields/field_types', [] );
		foreach ( $field_types as $field_type ) {
			if ( $field_type['is_hidden'] ) {
				continue;
			}

			$this->fields[ $field_type['type'] ] = [
				'name' => $field_type['label'],
			];
		}
	}

	public function get_fields() {
		return apply_filters( 'flexible_checkout_fields_fields', $this->fields );
	}


	/**
	 * Remove unavailable sections from settings.
	 * Removes sections added by PRO plugin, after PRO plugin disable.
	 *
	 * @param array $settings Settings.
	 *
	 * @return array
	 */
	private function get_settings_for_available_sections( array $settings ) {
		$this->init_sections();
		if ( is_array( $settings ) && is_array( $this->sections ) ) {
			foreach ( $settings as $section => $section_settings ) {
				$unset = true;
				foreach ( $this->sections as $section_data ) {
					if ( $section_data['section'] === $section ) {
						$unset = false;
					}
				}
				if ( $unset ) {
					unset( $settings[ $section ] );
				}
			}
		}

		return $settings;
	}

	/**
	 * Get settings.
	 *
	 * @return array
	 */
	public function get_settings() {
		$settings = get_option( 'inspire_checkout_fields_settings', array() );
		if ( ! is_array( $settings ) ) {
			$settings = array();
		}

		return $this->get_settings_for_available_sections( $settings );
	}

	public function woocommerce_before_checkout_form() {
		WC()->session->set( 'checkout-fields', array() );
		$settings = $this->get_settings();
		$args     = array( 'settings' => $settings );
		include $this->plugin_path . '/views/before-checkout-form.php';
	}


	/**
	 * @param array $settings
	 * @param array $fields
	 * @param array $new
	 * @param null|string $request_type
	 *
	 * @return array
	 */
	private function append_other_plugins_fields_to_checkout_fields( $settings, $fields, $new, $request_type ) {
		if ( $request_type === null ) {
			if ( ! empty( $fields ) && is_array( $fields ) ) {
				foreach ( $fields as $section => $section_fields ) {
					if ( ! empty( $section_fields ) && is_array( $section_fields ) ) {
						foreach ( $section_fields as $key => $field ) {
							if ( empty( $settings[ $section ][ $key ] ) ) {
								$new[ $section ][ $key ] = $field;
							}
						}
					}
				}
			}
		} else {
			foreach ( $fields as $key => $field ) {
				if ( empty( $settings[ $request_type ][ $key ] ) ) {
					$new[ $request_type ][ $key ] = $field;
				}
			}
		}

		return $new;
	}

	/**
	 * Is field requirement controlled by woocommerce.
	 *
	 * @param string $field_name .
	 *
	 * @return bool
	 */
	private function is_field_requirement_controlled_by_woocommerce( $field_name ) {
		return in_array( $field_name, self::FIELDS_REQUIREMENT_CONTROLLED_BY_WOOCOMMERCE, true );
	}

	/**
	 * @param array $fields
	 * @param null|string $request_type
	 *
	 * @return array
	 */
	public function getCheckoutFields( $fields, $request_type = null ) {
		$settings = $this->get_settings();

		$checkout_field_type = $this->get_fields();
		if ( ! empty( $settings ) ) {
			$new = array();
			if ( isset( $fields['account'] ) ) {
				$new['account'] = array();
			}
			$priority = 0;
			foreach ( $settings as $key => $type ) {

				if ( $key !== 'billing' && $key !== 'shipping' && $key !== 'order' ) {
					if ( get_option( 'inspire_checkout_fields_' . $key, '0' ) == '0' ) {
						continue;
					}
				}
				if ( ! is_array( $type ) ) {
					continue;
				}
				if ( $request_type == null || $request_type == $key ) {
					if ( ! isset( $new[ $key ] ) ) {
						$new[ $key ] = array();
					}
					$fields_found = true;
					foreach ( $type as $field_name => $field ) {
						if ( apply_filters( 'flexible_checkout_fields_condition', true, $field ) ) {
							if ( $field['visible'] == 0 or
							     ( ( isset( $_GET['page'] ) && $_GET['page'] == 'inspire_checkout_fields_settings' ) && $field['visible'] == 1 ) || $field['name'] == 'billing_country' || $field['name'] == 'shipping_country' ) {
								$fcf_field = new Flexible_Checkout_Fields_Field( $field, $this );
								$custom_field = $fcf_field->is_custom_field();
								if ( isset( $fields[ $key ][ $field['name'] ] ) ) {
									$new[ $key ][ $field['name'] ] = $fields[ $key ][ $field['name'] ];
								} else {
									$new[ $key ][ $field['name'] ] = $type[ $field['name'] ];
								}

								if ( ! $this->is_field_requirement_controlled_by_woocommerce( $field_name ) ) {
									if ( 1 === intval( $field['required'] ) ) {
										$new[ $key ][ $field['name'] ]['required'] = true;
									} else {
										$new[ $key ][ $field['name'] ]['required'] = false;
										if ( isset( $new[ $key ][ $field['name'] ]['validate'] ) ) {
											unset( $new[ $key ][ $field['name'] ]['validate'] );
										}
									}
								} else {
									if ( isset( $fields[ $key ][ $field['name'] ] ) ) {
										$new[ $key ][ $field['name'] ]['required'] = $fields[ $key ][ $field['name'] ]['required'];
									}
								}
								if ( isset( $field['label'] ) ) {
									$new[ $key ][ $field['name'] ]['label'] = stripcslashes( wpdesk__( $field['label'], 'flexible-checkout-fields' ) );

									// Support for fields rendered by WooCommerce
									if ( isset( $field['type'] ) && in_array( $field['type'], array( 'text', 'textarea', 'select' ), true ) ) {
										$new[ $key ][ $field['name'] ]['label'] = wp_kses_post( $new[ $key ][ $field['name'] ]['label'] );
									}
								}
								if ( isset( $field['placeholder'] ) ) {
									$new[ $key ][ $field['name'] ]['placeholder'] = wpdesk__( $field['placeholder'], 'flexible-checkout-fields' );
								} else {
									$new[ $key ][ $field['name'] ]['placeholder'] = '';
								}
								if ( ! is_array( $field['class'] ) ) {
									$new[ $key ][ $field['name'] ]['class'] = explode( ' ', $field['class'] );
								}
								if ( ( $field['name'] == 'billing_country' || $field['name'] == 'shipping_country' ) && $field['visible'] == 1 ) {
									$new[ $key ][ $field['name'] ]['class'][1] = "inspire_checkout_fields_hide";
								}
								if ( ! $custom_field ) {
									if ( isset( $field['validation'] ) && $field['validation'] != '' ) {
										if ( $field['validation'] == 'none' ) {
											unset( $new[ $key ][ $field['name'] ]['validate'] );
										} else {
											$new[ $key ][ $field['name'] ]['validate'] = array( $field['validation'] );
										}
									}
								} else {
									if ( isset( $field['validation'] ) && $field['validation'] != 'none' ) {
										$new[ $key ][ $field['name'] ]['validate'] = array( $field['validation'] );
									}
								}

								if ( ! empty( $field['type'] ) ) {
									$new[ $key ][ $field['name'] ]['type'] = $field['type'];
								}

								if ( $custom_field ) {
									$new[ $key ][ $field['name'] ]['type'] = $field['type'] ?? '';
								}

								if ( '' !== $fcf_field->get_default() ) {
									$new[ $key ][ $field['name'] ]['default'] = wpdesk__( $fcf_field->get_default(), 'flexible-checkout-fields' );
								}
							}
						}
					}
				}
			}

			$new = $this->append_other_plugins_fields_to_checkout_fields( $settings, $fields, $new, $request_type );

			foreach ( $new as $type => $new_fields ) {
				$priority = 0;
				foreach ( $new_fields as $key => $field ) {
					$priority                        += 10;
					$new[ $type ][ $key ]['priority'] = $priority;
				}
			}

			if ( $request_type == null ) {
				if ( ! empty( $fields['account'] ) ) {
					$new['account'] = $fields['account'];
				}

				$new = $this->restore_default_city_validation( $new, $_POST, 'billing' );
				$new = $this->restore_default_city_validation( $new, $_POST, 'shipping' );

				return $new;
			}
			if ( isset( $new[ $request_type ] ) ) {
				$new = $this->restore_default_city_validation( $new, $_POST, $request_type );

				return $new[ $request_type ];
			} else {
				return array();
			}
		} else {
			return $fields;
		}
	}

	/**
	 * Restores the default validation for the city
	 *
	 * @param array $fields Fields.
	 * @param array|null $request Request.
	 * @param string $request_type the type of shipping address (billing or shipping).
	 *
	 * @return array
	 */
	private function restore_default_city_validation( array $fields, $request, $request_type ) {

		if ( null === $request ) {
			$request = array();
		}

		$city    = $request_type . '_city';
		$country = $request_type . '_country';

		if ( isset( $fields[ $request_type ][ $city ]['required'] ) && isset( $request[ $country ] ) ) {
			$slug      = $request[ $country ];
			$countries = new WC_Countries();
			$locales   = $countries->get_country_locale();
			if ( isset( $locales[ $slug ]['city']['required'] ) ) {
				$required = $locales[ $slug ]['city']['required'];
				if ( ! $required ) {
					$fields[ $request_type ][ $city ]['required'] = 0;
					$fields[ $request_type ][ $city ]['hidden']   = 1;
				}
			}
		}

		return $fields;
	}

	public function getCheckoutUserFields( $fields, $request_type = null ) {
		$settings = $this->get_settings();

		$checkout_field_type = $this->get_fields();

		$priority = 0;

		if ( ! empty( $settings[ $request_type ] ) ) {
			foreach ( $settings[ $request_type ] as $key => $field ) {

				if ( $field['visible'] == 0 || $field['name'] === 'billing_country' || $field['name'] === 'shipping_country' || ( isset( $_GET['page'] ) && $_GET['page'] === 'inspire_checkout_fields_settings' && $field['visible'] == 1 ) ) {
					if ( ! empty( $fields[ $key ] ) ) {
						$new[ $key ] = $fields[ $key ];
					}

					if ( ! $this->is_field_requirement_controlled_by_woocommerce( $key ) ) {
						if ( $field['required'] == 1 ) {
							$new[ $key ]['required'] = true;
						} else {
							$new[ $key ]['required'] = false;
						}
					}

					if ( isset( $field['label'] ) ) {
						$new[ $key ]['label'] = wpdesk__( $field['label'], 'flexible-checkout-fields' );
					}

					if ( isset( $field['placeholder'] ) ) {
						$new[ $key ]['placeholder'] = wpdesk__( $field['placeholder'], 'flexible-checkout-fields' );
					} else {
						$new[ $key ]['placeholder'] = '';
					}

					if ( isset( $field['class'] ) ) {
						if ( is_array( $field['class'] ) ) {
							$new[ $key ]['class'] = explode( ' ', esc_attr( implode( ' ', $field['class'] ) ) );
						} else {
							$new[ $key ]['class'] = explode( ' ', esc_attr( $field['class'] ) );
						}
					}

					if ( ! empty( $field['name'] ) ) {
						if ( ( $field['name'] === 'billing_country' || $field['name'] === 'shipping_country' ) && $field['visible'] == 1 ) {
							$new[ $key ]['class'][] = "inspire_checkout_fields_hide";
						}
					}

					if ( ! empty( $field['type'] ) ) {
						$new[ $key ]['type'] = $field['type'];
					}

					$new[ $key ]['custom_attributes'] = apply_filters(
						'flexible_checkout_fields_custom_attributes',
						$field['custom_attributes'] ?? [],
						$field
					);
				}
			}

			/* added 02-02-2018 */
			foreach ( $fields as $field_key => $field ) {
				if ( empty( $new[ $field_key ] ) ) {
					$new[ $field_key ] = $field;
				}
			}

			if ( count( $fields ) ) {
				foreach ( $new as $key => $field ) {
					if ( empty( $fields[ $key ] ) ) {
						$new[ $key ]['custom_field'] = 1;
					}
				}
			}

			foreach ( $new as $key => $field ) {
				$priority                += 10;
				$new[ $key ]['priority'] = $priority;
			}

			return $new;
		} else {
			return $fields;
		}
	}

	public function printCheckoutFields( $order, $request_type = null ) {

		$settings = $this->getCheckoutFields( $this->get_settings() );

		$checkout_field_type = $this->get_fields();

		if ( ! empty( $settings ) ) {
			foreach ( $settings as $key => $type ) {
				if ( $request_type == null || $request_type == $key ) {
					$return = [];
					foreach ( $type as $field ) {
						if ( ( isset( $field['custom_field'] ) && $field['custom_field'] == 1 )
						     && ( empty( $field['type'] ) || ( ! empty( $checkout_field_type[ $field['type'] ] ) && empty( $checkout_field_type[ $field['type'] ]['exclude_in_admin'] ) ) )
						) {
							if ( $value = wpdesk_get_order_meta( $order, '_' . $field['name'], true ) ) {
								if ( isset( $field['type'] ) ) {
									$value = apply_filters( 'flexible_checkout_fields_print_value', nl2br( $value ), $field );
								}

								$return[] = sprintf(
									'<strong>%1$s</strong>: %2$s',
									strip_tags( $field['label'] ),
									wp_kses_post( $value )
								);
							}
						}
					}
				}
			}

			if ( ! empty( $return ) ) {
				echo '<div class="address_flexible_checkout_fields"><p class="form-field form-field-wide">' . implode( '<br />', $return ) . '</p></div>';
			}
		}
	}

	public function changeCheckoutFields( $fields ) {
		return $this->getCheckoutFields( $fields );
	}

	public function changeShippingFields( $fields ) {
		return $this->getCheckoutFields( $fields, 'shipping' );
	}

	public function changeBillingFields( $fields ) {
		return $this->getCheckoutFields( $fields, 'billing' );
	}

	public function changeOrderFields( $fields ) {
		return $this->getCheckoutFields( $fields, 'order' );
	}

	public function addCustomBillingFieldsToAdmin( $order ) {
		$this->printCheckoutFields( $order, 'billing' );
	}

	public function addCustomShippingFieldsToAdmin( $order ) {
		$this->printCheckoutFields( $order, 'shipping' );
	}

	public function addCustomOrderFieldsToAdmin( $order ) {
		$this->printCheckoutFields( $order, 'order' );
	}

	public function addCustomFieldsBillingFields( $fields ) {
		return $this->getCheckoutUserFields( $fields, 'billing' );
	}

	public function addCustomFieldsShippingFields( $fields ) {
		return $this->getCheckoutUserFields( $fields, 'shipping' );
	}

	public function addCustomFieldsOrderFields( $fields ) {
		return $this->getCheckoutUserFields( $fields, 'order' );
	}

	/**
	 * Update fields on checkout.
	 *
	 * @param int   $order_id Order id.
	 * @param array $data Posted data.
	 */
	function updateCheckoutFields( $order_id, $data ) {
		$settings = $this->get_settings();
		if ( ! empty( $settings ) ) {
			$fields = [];
			foreach ( $settings as $section_fields ) {
				$fields += $section_fields;
			}

			foreach ( $data as $key => $value ) {
				if ( isset( $fields[ $key ] ) ) {
					$fcf_field = new Flexible_Checkout_Fields_Field( $fields[ $key ], $this );
					if ( $fcf_field->is_custom_field() ) {
						if ( in_array( $fcf_field->get_type(), [ TextareaType::FIELD_TYPE ] ) ) {
							update_post_meta( $order_id, '_' . $key, sanitize_textarea_field( wp_unslash( $value ) ) );
						} elseif ( in_array( $fcf_field->get_type(), [ MultiCheckboxType::FIELD_TYPE, MultiSelectType::FIELD_TYPE, FileType::FIELD_TYPE ] ) ) {
							update_post_meta( $order_id, '_' . $key, json_encode( wp_unslash( $value ) ) );
						} else {
							update_post_meta( $order_id, '_' . $key, sanitize_text_field( wp_unslash( $value ) ) );
						}
					}
				}
			}
		}

		do_action( 'flexible_checkout_fields_checkout_update_order_meta', $order_id, $data );
	}

	public static function flexible_checkout_fields_section_settings( $key, $settings ) {
		echo 1;
	}

	public function woocommerce_get_country_locale_default( $address_fields ) {
		return $address_fields;
	}

	/**
	 * Add woocommerce screen ids.
	 *
	 * @param array $screen_ids Screen ids.
	 *
	 * @return array
	 */
	public function add_woocommerce_screen_ids( $screen_ids ) {
		$screen_ids[] = 'woocommerce_page_inspire_checkout_fields_settings';

		return $screen_ids;
	}

	/**
	 * Admin enqueue scripts.
	 */
	public function admin_enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		if (function_exists('get_current_screen')) {
			$current_screen = get_current_screen();
		}

		$deps = array(
			'jquery',
			'jquery-ui-sortable',
			'jquery-ui-tooltip',
			'jquery-ui-datepicker',
		);
		wp_enqueue_script( 'inspire_checkout_fields_admin_js', trailingslashit( $this->get_plugin_assets_url() ) . 'js/admin' . $suffix . '.js', $deps, $this->scripts_version );
	}

	/**
	 * Frontend enqueue scripts.
	 */
	public function wp_enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		if ( is_checkout() || is_account_page() ) {
			if ( $this->get_setting_value( 'css_disable' ) != 1 ) {
				wp_enqueue_style( 'jquery-ui-style', trailingslashit( $this->get_plugin_assets_url() ) . 'css/jquery-ui' . $suffix . '.css', array(), $this->scripts_version );
			}

			wp_enqueue_style( 'inspire_checkout_fields_public_style', trailingslashit( $this->get_plugin_assets_url() ) . 'css/front' . $suffix . '.css', array(), $this->scripts_version );
		}
		if ( is_checkout() || is_account_page() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_localize_jquery_ui_datepicker' ), 1000 );

			$deps = array(
				'jquery',
				'jquery-ui-datepicker',
			);
			wp_register_script( 'inspire_checkout_fields_checkout_js', trailingslashit( $this->get_plugin_assets_url() ) . 'js/checkout' . $suffix . '.js', $deps, $this->scripts_version );
			$translation_array = array(
				'uploading' => __( 'Uploading file...', 'flexible-checkout-fields' ),
			);
			wp_localize_script( 'inspire_checkout_fields_checkout_js', 'words', $translation_array );
			wp_enqueue_script( 'inspire_checkout_fields_checkout_js' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}
	}


	function wp_localize_jquery_ui_datepicker() {
		global $wp_locale;
		global $wp_version;

		if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) || version_compare( $wp_version, '4.6' ) != - 1 ) {
			return;
		}

		// Convert the PHP date format into jQuery UI's format.
		$datepicker_date_format = str_replace(
			array(
				'd',
				'j',
				'l',
				'z', // Day.
				'F',
				'M',
				'n',
				'm', // Month.
				'Y',
				'y'            // Year.
			),
			array(
				'dd',
				'd',
				'DD',
				'o',
				'MM',
				'M',
				'm',
				'mm',
				'yy',
				'y'
			),
			get_option( 'date_format' )
		);

		$datepicker_defaults = wp_json_encode( array(
			'closeText'       => __( 'Close' ),
			'currentText'     => __( 'Today' ),
			'monthNames'      => array_values( $wp_locale->month ),
			'monthNamesShort' => array_values( $wp_locale->month_abbrev ),
			'nextText'        => __( 'Next' ),
			'prevText'        => __( 'Previous' ),
			'dayNames'        => array_values( $wp_locale->weekday ),
			'dayNamesShort'   => array_values( $wp_locale->weekday_abbrev ),
			'dayNamesMin'     => array_values( $wp_locale->weekday_initial ),
			'dateFormat'      => $datepicker_date_format,
			'firstDay'        => absint( get_option( 'start_of_week' ) ),
			'isRTL'           => $wp_locale->is_rtl(),
		) );

		wp_add_inline_script( 'jquery-ui-datepicker', "jQuery(document).ready(function(jQuery){jQuery.datepicker.setDefaults({$datepicker_defaults});});" );
	}

	/**
	 * Links filter.
	 *
	 * @param array $links Links.
	 *
	 * @return array
	 */
	public function links_filter( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=inspire_checkout_fields_settings' ) . '">' . __( 'Settings', 'flexible-checkout-fields' ) . '</a>',
			'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-row-action-docs' ) ) . '" target="_blank">' . __( 'Docs', 'flexible-checkout-fields' ) . '</a>',
			'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-row-action-support' ) ) . '" target="_blank">' . __( 'Support', 'flexible-checkout-fields' ) . '</a>',
		);

		if ( ! wpdesk_is_plugin_active( 'flexible-checkout-fields-pro/flexible-checkout-fields-pro.php' ) ) {
			$plugin_links[] = '<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-row-action-upgrade' ) ) . '" target="_blank" style="color:#d64e07;font-weight:bold;">' . __( 'Upgrade', 'flexible-checkout-fields' ) . '</a>';
		}

		return array_merge( $plugin_links, $links );
	}

}
