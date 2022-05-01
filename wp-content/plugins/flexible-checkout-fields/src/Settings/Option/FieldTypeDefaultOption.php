<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class FieldTypeDefaultOption extends FieldTypeOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return 'text';
	}
}
