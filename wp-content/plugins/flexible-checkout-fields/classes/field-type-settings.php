<?php

/**
 * Field type settings.
 */
class Flexible_Checkout_Fields_Field_Type_Settings {

	const FIELD_TYPE_TEXT     = 'text';
	const FIELD_TYPE_TEXTAREA = 'textarea';

	/**
	 * Field type data.
	 *
	 * @var array
	 */
	private $field_type_settings;

	public function __construct( array $field_type_settings ) {
		$this->field_type_settings = $field_type_settings;
	}

	/**
	 * .
	 *
	 * @return bool
	 */
	public function has_options() {
		return isset( $this->field_type_settings['has_options'] ) && $this->field_type_settings['has_options'];
	}

	/**
	 * .
	 *
	 * @return bool
	 */
	public function has_default_value() {
		return isset( $this->field_type_settings['has_default_value'] ) && $this->field_type_settings['has_default_value'];
	}

	/**
	 * Is pro indicator set?
	 *
	 * @return bool
	 */
	public function is_pro() {
		return isset( $this->field_type_settings['pro'] ) ? intval( $this->field_type_settings['pro'] ) === 1 : false;
	}

}
