<?php

namespace WPDesk\FCF\Free\Settings\Option;

use WPDesk\FCF\Free\Settings\Tab\DisplayTab;

/**
 * {@inheritdoc}
 */
class DisplayOnOption extends OptionAbstract {

	const FIELD_NAME = 'display_on';

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
		return DisplayTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_CHECKBOX_LIST;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Pages/e-mails', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			DisplayOnThankYouOption::FIELD_NAME       => new DisplayOnThankYouOption(),
			DisplayOnAccountAddressOption::FIELD_NAME => new DisplayOnAccountAddressOption(),
			DisplayOnAccountOrderOption::FIELD_NAME   => new DisplayOnAccountOrderOption(),
			DisplayOnEmailsOption::FIELD_NAME         => new DisplayOnEmailsOption(),
		];
	}
}
