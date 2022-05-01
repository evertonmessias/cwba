<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class RequiredWcHiddenOption extends RequiredHiddenOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return __( 'Requirement of this field is controlled by WooCommerce and cannot be changed.', 'flexible-checkout-fields' );
	}
}
