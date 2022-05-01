<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class ValidationPostcodeOption extends ValidationOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		$rules = [
			''         => __( 'Default', 'flexible-checkout-fields' ),
			'none'     => __( 'None', 'flexible-checkout-fields' ),
			'email'    => __( 'E-mail', 'flexible-checkout-fields' ),
			'phone'    => __( 'Phone', 'flexible-checkout-fields' ),
			'postcode' => __( 'Postcode', 'flexible-checkout-fields' ),
		];

		$custom_rules = apply_filters( 'flexible_checkout_fields_custom_validation', [] );
		foreach ( $custom_rules as $rule_key => $rule_data ) {
			$rules[ $rule_key ] = $rule_data['label'];
		}
		return $rules;
	}
}
