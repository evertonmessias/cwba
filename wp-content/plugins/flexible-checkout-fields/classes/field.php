<?php

/**
 * Checkout field settings.
 */
class Flexible_Checkout_Fields_Field {

	const FIELD_TYPE         = 'type';
	const FIELD_CUSTOM_FIELD = 'custom_field';
	const FIELD_VISIBLE      = 'visible';
	const FIELD_DEFAULT      = 'default';

	const FIELD_DISPLAY_ON_OPTION_NEW_LINE_BEFORE = 'display_on_option_new_line_before';
	const FIELD_DISPLAY_ON_OPTION_SHOW_LABEL = 'display_on_option_show_label';

	const FIELD_TYPE_EXCLUDE_IN_ADMIN = 'exclude_in_admin';
	const FIELD_TYPE_EXCLUDE_FOR_USER = 'exclude_for_user';

	const DEFAULT_FIELD_TYPE = Flexible_Checkout_Fields_Field_Type_Settings::FIELD_TYPE_TEXT;

	const FIELD_TYPE_STATE = 'state';

	const DISPLAY_OPTION_STATE_CODE = 'state_code';
	const DISPLAY_OPTION_STATE_COMMA_BEFORE = 'state_code_comma_before';

	/**
	 * Field data.
	 *
	 * @var array
	 */
	private $field_data;

	/**
	 * Plugin.
	 *
	 * @var Flexible_Checkout_Fields_Plugin
	 */
	private $plugin;

	/**
	 * Flexible_Checkout_Fields_Field constructor.
	 *
	 * @param array                           $field_data Field data.
	 * @param Flexible_Checkout_Fields_Plugin $plugin Plugin.
	 */
	public function __construct( array $field_data, $plugin ) {
		$this->plugin     = $plugin;
		$this->field_data = $field_data;
	}

	/**
	 * @param array                           $field_data Field data.
	 * @param array                           $field_settings .
	 * @param Flexible_Checkout_Fields_Plugin $plugin Plugin.
	 *
	 * @return Flexible_Checkout_Fields_Field
	 */
	public static function create_with_settings( $field_data, $field_settings, $plugin ) {
		$fcf_field = new self( $field_data, $plugin );
		$fcf_field->add_field_settings( $field_settings );
		return $fcf_field;
	}

	/**
	 * Add settings to field.
	 *
	 * @param array $field_settings .
	 */
	public function add_field_settings( array $field_settings ) {
		foreach ( $field_settings as $key => $setting  ) {
			$this->field_data[ $key ] = $setting;
		}
	}

	/**
	 * Get field setting.
	 *
	 * @param string $setting_name .
	 * @param null|string|array $default_value .
	 *
	 * @return array|string|null
	 */
	public function get_field_setting( $setting_name, $default_value = null ) {
		if ( $setting_name === self::FIELD_DISPLAY_ON_OPTION_SHOW_LABEL ) {
			return $this->get_display_on_option_show_label();
		}
		if ( $setting_name === self::FIELD_DISPLAY_ON_OPTION_NEW_LINE_BEFORE ) {
			return $this->get_display_on_option_new_line_before();
		}
		if ( isset( $this->field_data[ $setting_name ] ) ) {
			return $this->field_data[ $setting_name ];
		} else {
			return $default_value;
		}
	}

	/**
	 * Get field types from plugin.
	 *
	 * @return array
	 */
	private function get_field_types_from_plugin() {
		return $this->plugin->get_fields();
	}

	/**
	 * Get field type settings.
	 *
	 * @return array
	 */
	private function get_field_type_settings() {
		$default_values = array(
			self::FIELD_TYPE_EXCLUDE_IN_ADMIN => false,
			self::FIELD_TYPE_EXCLUDE_FOR_USER => false,
		);
		$field_types    = $this->get_field_types_from_plugin();
		if ( isset( $this->field_data[ self::FIELD_TYPE ] ) && isset( $field_types[ $this->field_data[ self::FIELD_TYPE ] ] ) ) {
			$field_type_settings = $field_types[ $this->field_data[ self::FIELD_TYPE ] ];
			$field_type_settings = array_merge( $default_values, $field_type_settings );
			return $field_type_settings;
		}
		return $default_values;
	}

	/**
	 * Is visible?
	 *
	 * @return bool
	 */
	public function is_custom_field() {
		if ( isset( $this->field_data[ self::FIELD_CUSTOM_FIELD ] ) && 1 === intval( $this->field_data[ self::FIELD_CUSTOM_FIELD ] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Is visible?
	 *
	 * @return bool
	 */
	public function is_visible() {
		if ( isset( $this->field_data[ self::FIELD_VISIBLE ] ) && 0 === intval( $this->field_data[ self::FIELD_VISIBLE ] ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Is field excluded for user?
	 * Field is excluded from user when is custom field and is not visible or field type is excluded for user.
	 *
	 * @return bool
	 */
	public function is_field_excluded_for_user() {
		if ( ! $this->is_custom_field() ) {
			return false;
		}
		$field_type_settings = $this->get_field_type_settings();
		if ( true === $field_type_settings[ self::FIELD_TYPE_EXCLUDE_FOR_USER ] ) {
			return true;
		}
		return false;
	}

	/**
	 * Is field excluded in admin?
	 *
	 * @return bool
	 */
	public function is_field_excluded_in_admin() {
		if ( ! $this->is_custom_field() ) {
			return false;
		}
		$field_type_settings = $this->get_field_type_settings();
		if ( true === $field_type_settings[ self::FIELD_TYPE_EXCLUDE_IN_ADMIN ] ) {
			return true;
		}
		return false;
	}

	/**
	 * .
	 *
	 * @return string
	 */
	public function get_display_on_option_new_line_before() {
		if ( isset( $this->field_data[ self::FIELD_DISPLAY_ON_OPTION_NEW_LINE_BEFORE ] ) ) {
			return $this->field_data[ self::FIELD_DISPLAY_ON_OPTION_NEW_LINE_BEFORE ];
		} else {
			return '1';
		}
	}

	/**
	 * .
	 *
	 * @return string
	 */
	public function get_display_on_option_show_label() {
		if ( isset( $this->field_data[ self::FIELD_DISPLAY_ON_OPTION_SHOW_LABEL ] ) ) {
			return $this->field_data[ self::FIELD_DISPLAY_ON_OPTION_SHOW_LABEL ];
		} else {
			if ( $this->is_custom_field() ) {
				return '1';
			} else {
				return '0';
			}
		}
	}

	/**
	 * Set field type.
	 *
	 * @param string $type .
	 */
	public function set_type( $type ) {
		$this->field_data[ self::FIELD_TYPE ] = $type;
	}

	/**
	 * Get field type.
	 *
	 * @return string
	 */
	public function get_type() {
		return isset( $this->field_data[ self::FIELD_TYPE ] ) ? $this->field_data[ self::FIELD_TYPE ] : self::DEFAULT_FIELD_TYPE;
	}

	/**
	 * Get default value.
	 *
	 * @return string
	 */
	public function get_default() {
		return isset( $this->field_data[ self::FIELD_DEFAULT ] ) ? $this->field_data[ self::FIELD_DEFAULT ] : '';
	}

	/**
	 * Prepare display_on option name.
	 *
	 * @param string $display_on
	 *
	 * @return string
	 */
	public function prepare_display_on_option_name( $display_on ) {
		return 'display_on_option_' . $display_on;
	}

	/**
	 * Get field name for formatted address.
	 */
	public function get_name_for_address_format() {
		$name = $this->field_data['name'];
		if ( isset( $this->field_data[ $this->prepare_display_on_option_name( self::DISPLAY_OPTION_STATE_CODE ) ] )
		    && 1 === intval( $this->field_data[ $this->prepare_display_on_option_name( self::DISPLAY_OPTION_STATE_CODE ) ] )
		) {
			$name = 'state_code';
		}
		return $name;
	}

	/**
	 * Get display comma before field.
	 * Currently used only on state/county field.
	 */
	public function get_display_comma_before() {
		return isset( $this->field_data[ $this->prepare_display_on_option_name( self::DISPLAY_OPTION_STATE_COMMA_BEFORE ) ] )
			? $this->field_data[ $this->prepare_display_on_option_name( self::DISPLAY_OPTION_STATE_COMMA_BEFORE ) ] : '0';
	}

}
