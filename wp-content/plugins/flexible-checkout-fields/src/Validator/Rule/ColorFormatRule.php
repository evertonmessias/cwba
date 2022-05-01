<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Validator\Error\InvalidValueError;

/**
 * Checks that the color value is valid.
 */
class ColorFormatRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		if ( ( $value === '' ) || preg_match( '/^#[a-zA-Z0-9]{6}$/', $value ) ) {
			return null;
		}

		return new InvalidValueError( $field_data, $value );
	}
}
