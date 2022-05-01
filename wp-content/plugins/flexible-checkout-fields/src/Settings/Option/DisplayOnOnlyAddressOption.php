<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class DisplayOnOnlyAddressOption extends DisplayOnOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			DisplayOnAccountAddressOption::FIELD_NAME => new DisplayOnAccountAddressOption(),
		];
	}
}
