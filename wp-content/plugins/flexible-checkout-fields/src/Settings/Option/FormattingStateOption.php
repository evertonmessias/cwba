<?php

namespace WPDesk\FCF\Free\Settings\Option;

use WPDesk\FCF\Free\Settings\Tab\DisplayTab;

/**
 * {@inheritdoc}
 */
class FormattingStateOption extends OptionAbstract {

	const FIELD_NAME = 'formatting_state_options';

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
		return __( 'State/County formatting', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			FormattingStateAbbrOption::FIELD_NAME  => new FormattingStateAbbrOption(),
			FormattingStateCommaOption::FIELD_NAME => new FormattingStateCommaOption(),
		];
	}
}
