<?php

use WPDesk\FCF\Free\Field\Type\FileType;
use WPDesk\FCF\Free\Field\Type\MultiCheckboxType;
use WPDesk\FCF\Free\Field\Type\MultiSelectType;
use WPDesk\FCF\Free\Field\Type\TextareaType;

/**
 * Class Flexible_Checkout_Fields_Myaccount_Field_Processor
 */
class Flexible_Checkout_Fields_Myaccount_Field_Processor {

	/**
	 * @var Flexible_Checkout_Fields_Plugin
	 */
	protected $plugin;

	/**
	 * Flexible_Checkout_Fields_Myaccount_Field_Processor constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin $plugin Plugin.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Is custom field?
	 *
	 * @param array $field Field.
	 *
	 * @return bool
	 */
	private function is_custom_field( $field ) {
		if ( isset( $field['custom_field'] ) && 1 === intval( $field['custom_field'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		$settings = $this->plugin->get_settings();
		foreach ( $settings as $section ) {
			if ( is_array( $section ) ) {
				foreach ( $section as $key => $field ) {
					if ( ! $this->is_custom_field( $field ) ) {
						continue;
					}

					if ( in_array( $field['type'], [ TextareaType::FIELD_TYPE ] ) ) {
						add_filter( 'woocommerce_process_myaccount_field_' . $key, [ $this, 'sanitize_textarea_value' ] );
					} else if ( in_array( $field['type'], [ MultiCheckboxType::FIELD_TYPE, MultiSelectType::FIELD_TYPE, FileType::FIELD_TYPE ] ) ) {
						add_filter( 'woocommerce_process_myaccount_field_' . $key, [ $this, 'sanitize_array_value' ] );
					} else {
						add_filter( 'woocommerce_process_myaccount_field_' . $key, [ $this, 'sanitize_text_value' ] );
					}
				}
			}
		}
	}

	/**
	 * @param string|null $value .
	 *
	 * @return string
	 */
	public function sanitize_textarea_value( $value ) {
		return sanitize_textarea_field( wp_unslash( $value ) );
	}

	/**
	 * @param string|null $value .
	 *
	 * @return string
	 */
	public function sanitize_array_value( $value ) {
		return json_encode( wp_unslash( $value ) );
	}

	/**
	 * @param string|null $value .
	 *
	 * @return string
	 */
	public function sanitize_text_value( $value ) {
		return sanitize_text_field( wp_unslash( $value ) );
	}
}
