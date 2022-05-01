<?php

namespace WPDesk\FCF\Free\Settings;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FcfVendor\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use FcfVendor\WPDesk\PluginBuilder\Plugin\PluginAccess;
use FcfVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FcfVendor\WPDesk\View\Resolver\DirResolver;
use WPDesk\FCF\Free\Field\Types;
use WPDesk\FCF\Free\Settings\Route\RouteIntegration;

/**
 * Supports page of plugin settings.
 */
class Page implements Hookable, HookablePluginDependant {

	use PluginAccess;

	const SETTINGS_PAGE = 'inspire_checkout_fields_settings';

	/**
	 * Class object for template rendering.
	 *
	 * @var SimplePhpRenderer
	 */
	private $renderer;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->set_renderer();
	}

	/**
	 * Init class for template rendering.
	 */
	private function set_renderer() {
		$this->renderer = new SimplePhpRenderer( new DirResolver( dirname( dirname( __DIR__ ) ) . '/templates' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ], 80 );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_assets_for_settings_page' ], 80 );
	}

	/**
	 * Registers admin page for plugin settings.
	 *
	 * @internal
	 */
	public function add_settings_page() {
		add_submenu_page(
			'woocommerce',
			__( 'Checkout Fields Settings', 'flexible-checkout-fields' ),
			__( 'Checkout Fields', 'flexible-checkout-fields' ),
			'manage_woocommerce',
			self::SETTINGS_PAGE,
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Initiates loading of assets needed to operate admin page.
	 *
	 * @internal
	 */
	public function load_assets_for_settings_page() {
		if ( ! isset( $_GET['page'] ) || ( $_GET['page'] !== self::SETTINGS_PAGE ) ) { // phpcs:ignore
			return;
		}

		add_filter( 'admin_footer_text', [ $this, 'update_footer_text' ] );
		$this->load_styles_for_page();
		$this->load_scripts_for_page();
	}

	/**
	 * Loads admin page template.
	 *
	 * @internal
	 */
	public function render_settings_page() {
		$menu_tabs     = ( new Menu() )->get_menu_tabs();
		$menu_sections = ( new Menu() )->get_menu_sections();

		echo $this->renderer->render( // phpcs:ignore
			'views/admin-page',
			[
				'settings'      => $this->load_settings_data( $menu_sections ), // phpcs:ignore
				'menu_tabs'     => $menu_tabs, // phpcs:ignore
				'menu_sections' => $menu_sections, // phpcs:ignore
			]
		);
	}

	/**
	 * Returns set of data needed to support admin panel by JS code.
	 *
	 * @param array $menu_sections Items of menu with sections.
	 *
	 * @return array Settings of admin page.
	 */
	private function load_settings_data( array $menu_sections ): array {
		$settings = [
			'rest_api_url' => get_rest_url( null, RouteIntegration::REST_API_NAMESPACE ),
			'header_nonce' => wp_create_nonce( 'wp_rest' ),
			'i18n'         => $this->load_translations(),
		];

		switch ( $_GET['tab'] ?? '' ) { // phpcs:ignore
			case MENU::MENU_TAB_SETTINGS:
				$settings['form_settings'] = [
					'api_route'     => 'settings',
					'form_index'    => null,
					'option_fields' => apply_filters( 'flexible_checkout_fields/form_fields_settings', [] ),
					'option_values' => apply_filters( 'flexible_checkout_fields/form_data_settings', [] ),
					'settings_tabs' => [],
				];
				break;
			default:
				$section = $this->get_active_section( $menu_sections );
				if ( ! $section ) {
					break;
				}

				$settings['form_fields'] = [
					'api_route'     => sprintf( '%s/fields', $section['id'] ),
					'form_index'    => $section['id'],
					'option_fields' => apply_filters( 'flexible_checkout_fields/field_types', [], $section['id'] ),
					'option_values' => array_values( apply_filters( 'flexible_checkout_fields/form_data_fields', [], $section['id'] ) ),
					'settings_tabs' => apply_filters( 'flexible_checkout_fields/field_settings_tabs', [] ),
					'field_group'   => [
						[
							'name'  => Types::FIELD_GROUP_TEXT,
							'label' => __( 'Text Fields', 'flexible-checkout-fields' ),
						],
						[
							'name'  => Types::FIELD_GROUP_OPTION,
							'label' => __( 'Option Fields', 'flexible-checkout-fields' ),
						],
						[
							'name'  => Types::FIELD_GROUP_PICKER,
							'label' => __( 'Picker Fields', 'flexible-checkout-fields' ),
						],
						[
							'name'  => Types::FIELD_GROUP_OTHER,
							'label' => __( 'Other Fields', 'flexible-checkout-fields' ),
						],
					],
				];

				if ( ! $section['has_section_form'] ) {
					break;
				}
				$settings['form_section'] = [
					'api_route'     => sprintf( '%s/section', $section['id'] ),
					'form_index'    => $section['id'],
					'option_fields' => apply_filters( 'flexible_checkout_fields/form_fields_section', [], $section['id'] ),
					'option_values' => apply_filters( 'flexible_checkout_fields/form_data_section', [], $section['id'] ),
					'settings_tabs' => [],
				];
				break;
		}

		return $settings;
	}

	/**
	 * Returns active section from sections menu.
	 *
	 * @param array $menu_sections Items of menu with sections.
	 *
	 * @return array|null Active item of menu.
	 */
	private function get_active_section( array $menu_sections ) {
		foreach ( $menu_sections as $section ) {
			if ( $section['is_active'] ) {
				return $section;
			}
		}
		return null;
	}

	/**
	 * Returns list of translations used by JS code.
	 *
	 * @return array Translations values.
	 */
	private function load_translations(): array {
		return [
			'form_fields'             => __( 'Edit form', 'flexible-checkout-fields' ),
			'form_add_field'          => __( 'Add new field', 'flexible-checkout-fields' ),
			'form_section'            => __( 'Edit section', 'flexible-checkout-fields' ),
			'form_settings'           => __( 'Edit settings', 'flexible-checkout-fields' ),
			'button_add_field'        => __( 'Add Field', 'flexible-checkout-fields' ),
			'button_add_row'          => __( 'Add New', 'flexible-checkout-fields' ),
			'button_save'             => __( 'Save Changes', 'flexible-checkout-fields' ),
			'button_reset'            => __( 'Reset Section Settings', 'flexible-checkout-fields' ),
			'button_read_more'        => __( 'Read more', 'flexible-checkout-fields' ),
			'button_yes'              => __( 'Yes', 'flexible-checkout-fields' ),
			'button_no'               => __( 'No', 'flexible-checkout-fields' ),
			'button_upload_image'     => __( 'Upload image', 'flexible-checkout-fields' ),
			'button_select_color'     => __( 'Select color', 'flexible-checkout-fields' ),
			'field_type'              => __( 'Field Type', 'flexible-checkout-fields' ),
			'field_label'             => __( 'Label', 'flexible-checkout-fields' ),
			'field_name'              => __( 'Name', 'flexible-checkout-fields' ),
			'validation_required'     => __( 'This field is required.', 'flexible-checkout-fields' ),
			'validation_max_length'   => __( 'This value is too long.', 'flexible-checkout-fields' ),
			'validation_slug'         => __( 'Field name should contains only lowercase letters, numbers and underscore sign.', 'flexible-checkout-fields' ),
			'select_placeholder'      => __( 'Select...', 'flexible-checkout-fields' ),
			'select_loading'          => __( 'Loading...', 'flexible-checkout-fields' ),
			'select_empty'            => __( 'No options.', 'flexible-checkout-fields' ),
			'alert_field_unavailable' => sprintf(
			/* translators: %1$s: break line, %2$s: anchor opening tag, %3$s: anchor closing tag */
				__( 'This field is available in the PRO version.%1$s %2$sUpgrade to PRO%3$s', 'flexible-checkout-fields' ),
				'<br>',
				'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-type-upgrade' ) ) . '" target="_blank" class="fcfArrowLink">',
				'</a>'
			),
			'alert_remove_field'      => __( 'Are you sure you want to delete this field? Deleting a field will remove it from all orders.', 'flexible-checkout-fields' ),
			'alert_reset'             => __( 'Do you really want to reset section settings? Resetting a section remove all added fields from orders.', 'flexible-checkout-fields' ),
			'alert_no_fields'         => __( 'No fields available.', 'flexible-checkout-fields' ),
			'alert_failed_save'       => __( 'Failed to connect to WordPress REST API.', 'flexible-checkout-fields' ),
		];
	}

	/**
	 * Removes WooCommerce footer from plugin settings page.
	 *
	 * @return string New footer content.
	 * @internal
	 */
	public function update_footer_text(): string {
		return '';
	}

	/**
	 * Enqueues styles in WordPress Admin Dashboard.
	 */
	private function load_styles_for_page() {
		$is_debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );

		wp_register_style(
			'fcf-admin',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'css/new-admin.css',
			[],
			( $is_debug ) ? time() : $this->plugin->get_script_version()
		);
		wp_enqueue_style( 'fcf-admin' );
	}

	/**
	 * Enqueues scripts in WordPress Admin Dashboard.
	 */
	private function load_scripts_for_page() {
		$is_debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );

		wp_register_script(
			'fcf-admin',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'js/new-admin.js',
			[],
			( $is_debug ) ? time() : $this->plugin->get_script_version(),
			true
		);
		wp_enqueue_media();
		wp_enqueue_script( 'fcf-admin' );
	}
}
