<?php

namespace WPDesk\FCF\Free\Settings\Option;

use WPDesk\FCF\Free\Settings\Tab\LogicTab;

/**
 * {@inheritdoc}
 */
class LogicAdvOption extends OptionAbstract {

	const FIELD_NAME = 'conditional_logic_adv';

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
		return LogicTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_INFO_ADV;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		$url_products = esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-tab-logic-docs-products-upgrade' ) );
		$url_fields   = esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-tab-logic-docs-fields-upgrade' ) );
		$url_shipping = esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-tab-logic-docs-shipping-upgrade' ) );
		$url_upgrade  = esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-tab-logic-upgrade' ) );
		return sprintf(
		/* translators: %1$s: anchor opening tag, %2$s: anchor closing tag, %3$s: anchor opening tag, %4$s: anchor closing tag, %5$s: anchor opening tag, %6$s: anchor closing tag, %7$s: break line, %8$s: anchor opening tag, %9$s: anchor closing tag */
			__( 'Add conditional logic based on %1$sproducts and categories%2$s as well as %3$sFCF fields%4$s and %5$sshipping methods%6$s set. %7$s%8$sUpgrade to PRO%9$s', 'flexible-checkout-fields' ),
			'<a href="' . $url_products . '" target="_blank">',
			'</a>',
			'<a href="' . $url_fields . '" target="_blank">',
			'</a>',
			'<a href="' . $url_shipping . '" target="_blank">',
			'</a>',
			'<br>',
			'<a href="' . $url_upgrade . '" target="_blank" class="fcfArrowLink">',
			'</a>'
		);
	}
}
