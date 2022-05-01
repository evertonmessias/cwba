<?php

namespace WPDesk\FCF\Free\Settings\Tab;

/**
 * {@inheritdoc}
 */
class PricingTab extends TabAbstract {

	const TAB_NAME = 'pricing';

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
		return __( 'Pricing', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_icon(): string {
		return 'icon-dollar-sign';
	}
}
