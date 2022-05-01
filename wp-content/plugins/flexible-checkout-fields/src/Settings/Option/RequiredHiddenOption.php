<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class RequiredHiddenOption extends RequiredOption {

	/**
	 * {@inheritdoc}
	 */
	public function is_readonly(): bool {
		return true;
	}
}
