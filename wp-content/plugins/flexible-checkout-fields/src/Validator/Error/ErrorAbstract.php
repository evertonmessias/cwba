<?php

namespace WPDesk\FCF\Free\Validator\Error;

/**
 * {@inheritdoc}
 */
abstract class ErrorAbstract implements ValidatorError {

	/**
	 * @var array
	 */
	protected $field_data;

	/**
	 * @var string
	 */
	protected $value;

	/**
	 * {@inheritdoc}
	 */
	public function __construct( array $field_data, string $value ) {
		$this->field_data = $field_data;
		$this->value      = $value;
	}
}
