<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class SettingJqueryCssOption extends OptionAbstract {

	const FIELD_NAME = 'inspire_checkout_fields_css_disable';

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
		return __( 'Disable jquery-ui.css on the frontend', 'flexible-checkout-fields' );
	}

	/**
	 * Returns label of option.
	 *
	 * @return string Option label.
	 */
	public function get_label_tooltip(): string {
		return __( 'Remember that some fields, i.e. datepicker use jQuery UI CSS. The plugin adds a default CSS but sometimes it can create some visual glitches.', 'flexible-checkout-fields' );
	}
}
