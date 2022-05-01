<?php

namespace WPDesk\FCF\Free\Settings\Tab;

/**
 * {@inheritdoc}
 */
class DisplayTab extends TabAbstract {

	const TAB_NAME = 'display-on';

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
		return __( 'Display On', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_icon(): string {
		return 'icon-eye';
	}
}
