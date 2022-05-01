<?php

namespace WPDesk\FCF\Free\Settings\Tab;

/**
 * {@inheritdoc}
 */
class AdvancedTab extends TabAbstract {

	const TAB_NAME = 'advanced';

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_name(): string {
		return self::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_label(): string {
		return __( 'Advanced', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_icon(): string {
		return 'icon-cogs';
	}
}
