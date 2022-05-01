<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Validator\Error\InvalidEmailError;

/**
 * Checks that the e-mail value is valid.
 */
class EmailFormatRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		if ( ( $value === '' ) || filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return null;
		}

		return new InvalidEmailError( $field_data, $value );
	}
}
