<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Settings\Option\ValueMaxOption;
use WPDesk\FCF\Free\Validator\Error\NumberMaxError;

/**
 * Checks that number meets maximum value requirement.
 */
class NumberMaxRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		$number_max = $field_data[ ValueMaxOption::FIELD_NAME ] ?? '';
		if ( ( $value === '' ) || ( $number_max === '' ) || ( $value <= $number_max ) ) {
			return null;
		}

		return new NumberMaxError( $field_data, $value );
	}
}
