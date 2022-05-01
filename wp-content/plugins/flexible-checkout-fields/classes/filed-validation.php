<?php

use WPDesk\FCF\Free\Field\Type\FileType;
use WPDesk\FCF\Free\Field\Type\MultiCheckboxType;
use WPDesk\FCF\Free\Field\Type\MultiSelectType;
use WPDesk\FCF\Free\Field\Type\TextareaType;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Flexible_Checkout_Fields_Field_Validation {

	/**
	 * @var Flexible_Checkout_Fields_Plugin
	 */
	protected $plugin;

	/**
	 * Flexible_Checkout_Fields_Field_Validation constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 *
	 */
	public function hooks() {
		add_action( 'woocommerce_after_checkout_validation', array( $this, 'woocommerce_after_checkout_validation_action' ) );
		add_filter( 'woocommerce_checkout_required_field_notice', array( $this, 'woocommerce_checkout_required_field_notice_filter' ), 10, 2 );
	}

	public function woocommerce_checkout_required_field_notice_filter( $notice, $field_label ) {
		$field_label = strip_tags( $field_label );
		$notice = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . $field_label . '</strong>' );
		return $notice;
	}

	/**
	 * @param $data
	 */
	public function woocommerce_after_checkout_validation_action( $data ) {
		foreach ( $data as $field => $value ) {
			do_action( 'flexible_checkout_fields_validate_' . $field, $value );
		}
		$settings = $this->plugin->get_settings();
		$custom_validations = $this->get_custom_validations();
		foreach ( $settings as $section => $fields ) {
			foreach ( $fields as $field_key => $field ) {
				if ( isset( $_POST[$field_key] ) && !empty( $field['validation'] ) && array_key_exists( $field['validation'], $custom_validations ) ) {
					call_user_func( $custom_validations[$field['validation']]['callback'], $field['label'], sanitize_textarea_field($_POST[$field_key]), $field );
				}
				if ( ! ( $field['custom_field'] ?? false ) ) {
					continue;
				}

				if ( in_array( $field['type'], [ TextareaType::FIELD_TYPE ] ) ) {
					$value = sanitize_textarea_field( wp_unslash( $_POST[ $field_key ] ?? '' ) );
				} elseif ( in_array( $field['type'], [ MultiCheckboxType::FIELD_TYPE, MultiSelectType::FIELD_TYPE, FileType::FIELD_TYPE ] ) ) {
					$value = json_encode( wp_unslash( $_POST[ $field_key ] ?? [] ) );
				} else {
					$value = sanitize_text_field( wp_unslash( $_POST[ $field_key ] ?? '' ) );
				}

				do_action( 'flexible_checkout_fields_validate_' . $field['type'], $value, $field );
			}
		}
	}

	/**
	 * Get custom validations.
	 *
	 * @param string $section .
	 * @return array
	 */
	public function get_custom_validations( $section = '' ) {
		return apply_filters( 'flexible_checkout_fields_custom_validation', array(), $section );
	}

	/**
	 * Get validation options.
	 *
	 * @param string $section .
	 * @return array
	 */
	public function get_validation_options( $section = '' ) {
		$validation_options = array(
			''      => __( 'Default', 'flexible-checkout-fields' ),
			'none'  => __( 'None', 'flexible-checkout-fields' ),
			'email' => __( 'Email', 'flexible-checkout-fields' ),
			'phone' => __( 'Phone', 'flexible-checkout-fields' ),
		);
		if ( in_array( $section, array( 'billing', 'shipping' ), true ) ) {
			$validation_options['postcode'] = __( 'Postcode', 'flexible-checkout-fields' );
		}
		$custom_validations = $this->get_custom_validations( $section );
		foreach ( $custom_validations as $custom_validation_key => $custom_validation ) {
			$validation_options[ $custom_validation_key ] = $custom_validation['label'];
		}
		return $validation_options;
	}

}
