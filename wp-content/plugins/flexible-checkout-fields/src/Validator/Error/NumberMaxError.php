<?php

namespace WPDesk\FCF\Free\Validator\Error;

use WPDesk\FCF\Free\Settings\Option\ValueMaxOption;

/**
 * {@inheritdoc}
 */
class NumberMaxError extends ErrorAbstract {

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message(): string {
		return sprintf(
		/* translators: %1$s: field label, %2$s: minimum value */
			__( 'The maximum value for the %1$s field is %2$s.', 'flexible-checkout-fields' ),
			sprintf( '<strong>%s</strong>', strip_tags( $this->field_data['label'] ) ),
			esc_html( $this->field_data[ ValueMaxOption::FIELD_NAME ] )
		);
	}
}
