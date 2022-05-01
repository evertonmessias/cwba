<?php

namespace WPDesk\FCF\Free\Settings\Option;

use WPDesk\FCF\Free\Settings\Tab\AdvancedTab;

/**
 * {@inheritdoc}
 */
class ValidationOption extends OptionAbstract {

	const FIELD_NAME = 'validation';

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
		return AdvancedTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_RADIO;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Validation', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		$rules = [
			'' => __( 'Default', 'flexible-checkout-fields' ),
		];

		$custom_rules = apply_filters( 'flexible_checkout_fields_custom_validation', [] );
		foreach ( $custom_rules as $rule_key => $rule_data ) {
			$rules[ $rule_key ] = $rule_data['label'];
		}
		return $rules;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return '';
	}
}
