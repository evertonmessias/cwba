<?php

namespace WPDesk\FCF\Free\Settings\Option;

use WPDesk\FCF\Free\Settings\Tab\GeneralTab;

/**
 * {@inheritdoc}
 */
class LabelOption extends OptionAbstract {

	const FIELD_NAME = 'label';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_tab(): string {
		return GeneralTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_TEXTAREA;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_validation_rules(): array {
		return [
			'^.{1,}$' => __( 'This field is required.', 'flexible-checkout-fields' ),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Label', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function sanitize_option_value( $field_value ) {
		return wp_kses_post( wp_unslash( $field_value ) );
	}
}
