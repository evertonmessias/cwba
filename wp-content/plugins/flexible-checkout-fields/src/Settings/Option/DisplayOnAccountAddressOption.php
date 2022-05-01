<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class DisplayOnAccountAddressOption extends OptionAbstract {

	const FIELD_NAME = 'display_on_address';

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
		return __( 'My Account - address', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return '1';
	}
}
