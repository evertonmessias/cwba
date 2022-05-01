<?php

namespace WPDesk\FCF\Free\Validator;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\FCF\Free\Settings\Option\CssOption;
use WPDesk\FCF\Free\Settings\Option\RequiredOption;
use WPDesk\FCF\Free\Settings\Option\ValidationOption;

/**
 * Adds validation classes to the field template.
 */
class ValidationClassGenerator implements Hookable {

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_checkout_fields_field_args', [ $this, 'add_validation_required_class' ], 10, 2 );
		add_filter( 'flexible_checkout_fields_field_args', [ $this, 'add_validation_type_class' ], 10, 2 );
	}

	/**
	 * @param mixed[] $field_data .
	 * @param string  $field_name .
	 *
	 * @return mixed[]
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
	 * @param mixed[] $field_data .
	 * @param string  $field_name .
	 *
	 * @return mixed[]
	 */
	public function add_validation_type_class( array $field_data, string $field_name ): array {
		$validation_type = $field_data[ ValidationOption::FIELD_NAME ] ?? '';
		if ( ! $validation_type ) {
			return $field_data;
		}

		$field_data[ CssOption::FIELD_NAME ] .= sprintf( ' validate-%s', $validation_type );
		return $field_data;
	}
}
