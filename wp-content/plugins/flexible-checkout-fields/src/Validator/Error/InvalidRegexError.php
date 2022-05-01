<?php

namespace WPDesk\FCF\Free\Validator\Error;

use WPDesk\FCF\Free\Settings\Option\RegexMessageOption;

/**
 * {@inheritdoc}
 */
class InvalidRegexError extends ErrorAbstract {

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message(): string {
		return sprintf(
			esc_html( $this->field_data[ RegexMessageOption::FIELD_NAME ] ),
			sprintf( '<strong>%s</strong>', strip_tags( $this->field_data['label'] ) )
		);
	}
}
