<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Settings\Option\ValueMinOption;
use WPDesk\FCF\Free\Validator\Error\NumberMinError;

/**
 * Checks that number meets minimum value requirement.
 */
class NumberMinRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		$number_min = $field_data[ ValueMinOption::FIELD_NAME ] ?? '';
		if ( ( $value === '' ) || ( $number_min === '' ) || ( $value >= $number_min ) ) {
			return null;
		}

		return new NumberMinError( $field_data, $value );
	}
}
