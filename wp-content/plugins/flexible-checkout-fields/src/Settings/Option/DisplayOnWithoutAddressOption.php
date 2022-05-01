<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class DisplayOnWithoutAddressOption extends DisplayOnOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			DisplayOnThankYouOption::FIELD_NAME     => new DisplayOnThankYouOption(),
			DisplayOnAccountOrderOption::FIELD_NAME => new DisplayOnAccountOrderOption(),
			DisplayOnEmailsOption::FIELD_NAME       => new DisplayOnEmailsOption(),
		];
	}
}
