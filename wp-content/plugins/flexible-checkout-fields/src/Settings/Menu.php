<?php

namespace WPDesk\FCF\Free\Settings;

/**
 * Supports items for menu plugin settings page.
 */
class Menu {

	const OPTION_NAME_ENABLED = 'inspire_checkout_fields_%s';
	const MENU_TAB_SETTINGS   = 'settings';
	const MENU_TAB_SECTIONS   = 'sections';

	/**
	 * List of default checkout sections.
	 *
	 * @var array
	 */
	private static $default_field_sections = [
		'billing',
		'shipping',
		'order',
	];

	/**
	 * Returns list of items for menu with tabs.
	 *
	 * @return array Menu items.
	 */
	public function get_menu_tabs(): array {
		$current_tab = $_GET['tab'] ?? self::MENU_TAB_SECTIONS; // phpcs:ignore
		$page_tabs   = [
			self::MENU_TAB_SETTINGS => __( 'Settings', 'flexible-checkout-fields' ),
			self::MENU_TAB_SECTIONS => __( 'Checkout Sections', 'flexible-checkout-fields' ),
		];

		$values = [];
		foreach ( $page_tabs as $tab_id => $tab_name ) {
			$values[] = [
				'id'        => $tab_id,
				'label'     => $tab_name,
				'url'       => admin_url(
					sprintf(
						'admin.php?page=%s&tab=%s',
						Page::SETTINGS_PAGE,
						$tab_id
					)
				),
				'is_active' => ( $tab_id === $current_tab ),
			];
		}
		return $values;
	}

	/**
	 * Returns list of items for menu with sections.
	 *
	 * @return array Menu items.
	 */
	public function get_menu_sections(): array {
		$current_tab = $_GET['tab'] ?? self::MENU_TAB_SECTIONS; // phpcs:ignore
		if ( $current_tab !== self::MENU_TAB_SECTIONS ) {
			return [];
		}

		$current_section = $_GET['section'] ?? 'billing'; // phpcs:ignore
		$page_sections   = [
			'billing'  => __( 'Billing', 'flexible-checkout-fields' ),
			'shipping' => __( 'Shipping', 'flexible-checkout-fields' ),
			'order'    => __( 'Order', 'flexible-checkout-fields' ),
		];

		$sections = apply_filters( 'flexible_checkout_fields_all_sections', [] );
		foreach ( $sections as $section ) {
			$page_sections[ $section['section'] ] = $section['tab_title'];
		}

		$values = [];
		foreach ( $page_sections as $section_id => $section_name ) {
			if ( ! in_array( $section_id, self::$default_field_sections, true )
				&& ( get_option( sprintf( self::OPTION_NAME_ENABLED, $section_id ) ) !== '1' ) ) {
				continue;
			}

			$values[] = [
				'id'               => $section_id,
				'label'            => $section_name,
				'url'              => admin_url(
					sprintf(
						'admin.php?page=%s&tab=sections&section=%s',
						Page::SETTINGS_PAGE,
						$section_id
					)
				),
				'is_active'        => ( $section_id === $current_section ),
				'has_section_form' => ( ! in_array( $section_id, self::$default_field_sections, true ) ),
			];
		}
		return $values;
	}
}
