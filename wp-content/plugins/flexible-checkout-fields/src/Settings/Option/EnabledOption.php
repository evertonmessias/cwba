<?php

namespace WPDesk\FCF\Free\Settings\Option;

use WPDesk\FCF\Free\Settings\Tab\GeneralTab;

/**
 * {@inheritdoc}
 */
class EnabledOption extends OptionAbstract {

	const FIELD_NAME = 'visible';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_tab(): string {
		return GeneralTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_CHECKBOX;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Enable field', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return '1';
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_field_data( array $field_data, array $field_settings ): array {
		$option_name  = $this->get_option_name();
		$option_value = $field_settings[ $option_name ] ?? 0;

		$field_data[ $option_name ] = $this->sanitize_option_value( ( $option_value ) ? '0' : '1' );
		return $field_data;
	}
}
