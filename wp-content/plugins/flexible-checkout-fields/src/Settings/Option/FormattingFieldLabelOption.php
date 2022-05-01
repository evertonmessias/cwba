<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class FormattingFieldLabelOption extends OptionAbstract {

	const FIELD_NAME = 'display_on_option_show_label';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
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
		return __( 'Display field label', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return '1';
	}
}
