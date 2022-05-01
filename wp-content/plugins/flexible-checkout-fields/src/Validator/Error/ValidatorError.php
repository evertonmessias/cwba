<?php

namespace WPDesk\FCF\Free\Validator\Error;

interface ValidatorError {

	/**
	 * @param array  $field_data .
	 * @param string $value      .
	 *
	 * @return void
	 */
	public function __construct( array $field_data, string $value );

	/**
	 * @return string
	 */
	public function get_error_message(): string;
}
