<?php

namespace WPDesk\FCF\Free\Validator\Error;

use WPDesk\FCF\Free\Settings\Option\ValueStepOption;

/**
 * {@inheritdoc}
 */
class NumberStepError extends ErrorAbstract {

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message(): string {
		return sprintf(
		/* translators: %1$s: field label, %2$s: divider */
			__( 'The value of the %1$s field should be divisible by %2$s.', 'flexible-checkout-fields' ),
			sprintf( '<strong>%s</strong>', strip_tags( $this->field_data['label'] ) ),
			esc_html( $this->field_data[ ValueStepOption::FIELD_NAME ] )
		);
	}
}
