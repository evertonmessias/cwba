<?php

namespace WPDesk\FCF\Free\Validator;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\FCF\Free\Field\Type\ColorType;
use WPDesk\FCF\Free\Field\Type\EmailType;
use WPDesk\FCF\Free\Field\Type\NumberType;
use WPDesk\FCF\Free\Field\Type\PhoneType;
use WPDesk\FCF\Free\Field\Type\UrlType;
use WPDesk\FCF\Free\Settings\Option\CssOption;
use WPDesk\FCF\Free\Settings\Option\RequiredOption;
use WPDesk\FCF\Free\Settings\Option\ValidationOption;
use WPDesk\FCF\Free\Validator\Rule\ColorFormatRule;
use WPDesk\FCF\Free\Validator\Rule\EmailFormatRule;
use WPDesk\FCF\Free\Validator\Rule\NumberMaxRule;
use WPDesk\FCF\Free\Validator\Rule\NumberMinRule;
use WPDesk\FCF\Free\Validator\Rule\NumberStepRule;
use WPDesk\FCF\Free\Validator\Rule\UrlFormatRule;
use WPDesk\FCF\Free\Validator\Rule\ValidatorRule;
use WPDesk\FCF\Free\Validator\Rule\ValueRegexRule;

/**
 * Supports the validation of field values.
 */
class FieldValidator implements Hookable {

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'flexible_checkout_fields_validate_' . NumberType::FIELD_TYPE, [ $this, 'validate_number_field' ], 10, 2 );
		add_action( 'flexible_checkout_fields_validate_' . EmailType::FIELD_TYPE, [ $this, 'validate_email_field' ], 10, 2 );
		add_action( 'flexible_checkout_fields_validate_' . PhoneType::FIELD_TYPE, [ $this, 'validate_phone_field' ], 10, 2 );
		add_action( 'flexible_checkout_fields_validate_' . UrlType::FIELD_TYPE, [ $this, 'validate_url_field' ], 10, 2 );
		add_action( 'flexible_checkout_fields_validate_' . ColorType::FIELD_TYPE, [ $this, 'validate_color_field' ], 10, 2 );
	}

	/**
	 * @param array  $field_data .
	 * @param string $field_name .
	 *
	 * @return array
	 */
	public function add_validation_required_class( array $field_data, string $field_name ): array {
		$field_required = $field_data[ RequiredOption::FIELD_NAME ] ?? '';
		if ( ! $field_required ) {
			return $field_data;
		}

		$field_data[ CssOption::FIELD_NAME ] .= ' validate-required';
		return $field_data;
	}

	/**
	 * @param array  $field_data .
	 * @param string $field_name .
	 *
	 * @return array
	 */
	public function add_validation_type_class( array $field_data, string $field_name ): array {
		$validation_type = $field_data[ ValidationOption::FIELD_NAME ] ?? '';
		if ( ! $validation_type ) {
			return $field_data;
		}

		$field_data[ CssOption::FIELD_NAME ] .= sprintf( ' validate-%s', $validation_type );
		return $field_data;
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function validate_email_field( string $value, array $field_data ) {
		$this->validate_field_value( new EmailFormatRule(), $value, $field_data );
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function validate_number_field( string $value, array $field_data ) {
		$this->validate_field_value( new NumberMinRule(), $value, $field_data );
		$this->validate_field_value( new NumberMaxRule(), $value, $field_data );
		$this->validate_field_value( new NumberStepRule(), $value, $field_data );
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function validate_phone_field( string $value, array $field_data ) {
		$this->validate_field_value( new ValueRegexRule(), $value, $field_data );
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function validate_url_field( string $value, array $field_data ) {
		$this->validate_field_value( new UrlFormatRule(), $value, $field_data );
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function validate_color_field( string $value, array $field_data ) {
		$this->validate_field_value( new ColorFormatRule(), $value, $field_data );
	}

	private function validate_field_value( ValidatorRule $rule, string $value, array $field_data ): bool {
		$validator_error = $rule->validate_value( $value, $field_data );
		if ( $validator_error === null ) {
			return true;
		}

		wc_add_notice( $validator_error->get_error_message(), 'error' );
		return false;
	}
}
