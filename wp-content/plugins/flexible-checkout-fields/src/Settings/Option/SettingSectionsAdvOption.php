<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class SettingSectionsAdvOption extends OptionAbstract {

	const FIELD_NAME = 'settings_sections_adv';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
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
		$url = esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-section-custom-upgrade' ) );
		return '<p><strong>' . __( 'Get Flexible Checkout Fields PRO to use Custom Sections', 'flexible-checkout-fields' ) . '</strong></p>
			<ul>
				<li>' . __( 'Extend the form with additional fields. Insert Text inputs and Headings. Add Checkboxes and fields with options like DropDown or Radio.', 'flexible-checkout-fields' ) . '</li>
				<li>' . __( 'Add conditional logic based on products and categories as well as FCF fields and shipping methods.', 'flexible-checkout-fields' ) . '</li>
				<li>' . __( 'Add a fixed or percentage price to the field and set the tax on this price.', 'flexible-checkout-fields' ) . '</li>
			</ul>
			<p><a href="' . $url . '" target="_blank" class="fcfArrowLink">' . __( 'Upgrade to PRO', 'flexible-checkout-fields' ) . '</a></p>';
	}
}
