<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class FormattingWcOption extends FormattingOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			FormattingNewLineOption::FIELD_NAME => new FormattingNewLineOption(),
		];
	}
}
