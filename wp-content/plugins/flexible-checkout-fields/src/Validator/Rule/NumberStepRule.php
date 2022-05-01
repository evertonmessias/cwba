<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Settings\Option\ValueStepOption;
use WPDesk\FCF\Free\Validator\Error\NumberStepError;

/**
 * Checks step param for number value.
 */
class NumberStepRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		$number_step = $field_data[ ValueStepOption::FIELD_NAME ] ?: 1;
		if ( ( $value === '' ) || ( $value % $number_step === 0 ) ) {
			return null;
		}

		return new NumberStepError( $field_data, $value );
	}
}
