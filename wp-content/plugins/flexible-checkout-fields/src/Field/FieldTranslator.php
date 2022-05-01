<?php

namespace WPDesk\FCF\Free\Field;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;

/**
 * Supports translating field settings via external plugins.
 */
class FieldTranslator implements Hookable {

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_checkout_fields_field_args', [ $this, 'translate_field' ], 10, 2 );
	}

	/**
	 * @param mixed[] $field_data .
	 * @param string  $field_name .
	 *
	 * @return mixed[]
	 */
	public function translate_field( $field_data, $field_name ) {
		if ( isset( $field_data['label'] ) ) {
			$field_data['label'] = wpdesk__( $field_data['label'], 'flexible-checkout-fields' );
		}
		if ( isset( $field_data['placeholder'] ) ) {
			$field_data['placeholder'] = wpdesk__( $field_data['placeholder'], 'flexible-checkout-fields' );
		}
		if ( isset( $field_data['default'] ) ) {
			$field_data['default'] = wpdesk__( $field_data['default'], 'flexible-checkout-fields' );
		}
		if ( isset( $field_data['options'] ) ) {
			foreach ( $field_data['options'] as $option_index => $option ) {
				$field_data['options'][ $option_index ]['value'] = wpdesk__( $option['value'], 'flexible-checkout-fields' );
			}
		}

		return $field_data;
	}
}
