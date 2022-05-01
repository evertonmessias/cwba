<?php

namespace WPDesk\FCF\Free\Settings\Tab;

/**
 * {@inheritdoc}
 */
class AppearanceTab extends TabAbstract {

	const TAB_NAME = 'appearance';

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
		return __( 'Appearance', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_icon(): string {
		return 'icon-brush';
	}
}
