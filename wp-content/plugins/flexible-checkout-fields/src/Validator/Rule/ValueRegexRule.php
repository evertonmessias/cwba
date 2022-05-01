<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Settings\Option\RegexPhoneOption;
use WPDesk\FCF\Free\Validator\Error\InvalidRegexError;

/**
 * Checks that value is valid.
 */
class ValueRegexRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		$validation_regex = $field_data[ RegexPhoneOption::FIELD_NAME ];
		if ( ( $validation_regex === '' ) || ( $value === '' )
			|| preg_match( '/^' . $validation_regex . '$/', $value ) ) {
			return null;
		}

		return new InvalidRegexError( $field_data, $value );
	}
}
