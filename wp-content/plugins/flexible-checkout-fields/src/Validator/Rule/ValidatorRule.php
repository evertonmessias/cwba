<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Validator\Error\ValidatorError;

interface ValidatorRule {

	/**
	 * @param string $value      .
	 * @param array  $field_data .
	 *
	 * @return ValidatorError|null
	 */
	public function validate_value( string $value, array $field_data );
}
