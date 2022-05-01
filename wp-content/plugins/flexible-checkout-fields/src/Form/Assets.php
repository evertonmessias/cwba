<?php

namespace WPDesk\FCF\Free\Form;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FcfVendor\WPDesk_Plugin_Info;

/**
 * Initiates loading of assets required to handle the form.
 */
class Assets implements Hookable {

	const ASSETS_HANDLE_PATTERN = 'fcf-assets-%s';

	/**
	 * @var WPDesk_Plugin_Info
	 */
	private $plugin_info;

	public function __construct( WPDesk_Plugin_Info $plugin_info ) {
		$this->plugin_info = $plugin_info;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'wp_enqueue_scripts', [ $this, 'load_front_assets' ] );
		add_action( 'admin_print_scripts-post.php', [ $this, 'load_admin_order_assets' ] );
		add_action( 'admin_print_scripts-post-new.php', [ $this, 'load_admin_order_assets' ] );
		add_action( 'admin_print_scripts-profile.php', [ $this, 'load_checkout_assets' ] );
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function load_front_assets() {
		if ( ! is_checkout() && ! is_account_page() ) {
			return;
		}

		$this->load_checkout_assets();
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function load_admin_order_assets() {
		global $post_type;
		if ( $post_type !== 'shop_order' ) {
			return;
		}

		$this->load_checkout_assets();
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function load_checkout_assets() {
		wp_enqueue_style(
			sprintf( self::ASSETS_HANDLE_PATTERN, 'new-admin-css' ),
			sprintf( '%1$s/assets/css/new-front.css', untrailingslashit( $this->plugin_info->get_plugin_url() ) ),
			[],
			$this->plugin_info->get_version()
		);

		wp_enqueue_script(
			sprintf( self::ASSETS_HANDLE_PATTERN, 'new-admin-js' ),
			sprintf( '%1$s/assets/js/new-front.js', untrailingslashit( $this->plugin_info->get_plugin_url() ) ),
			[ 'jquery' ],
			$this->plugin_info->get_version(),
			true
		);
	}
}
