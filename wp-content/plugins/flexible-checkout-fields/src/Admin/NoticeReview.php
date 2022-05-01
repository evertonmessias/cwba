<?php

namespace WPDesk\FCF\Free\Admin;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FcfVendor\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use FcfVendor\WPDesk\PluginBuilder\Plugin\PluginAccess;
use FcfVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FcfVendor\WPDesk\View\Resolver\DirResolver;

/**
 * Creates admin notice about review.
 */
class NoticeReview implements Hookable, HookablePluginDependant {

	use PluginAccess;

	const ACTIVATION_OPTION_NAME = 'plugin_activation_%s';
	const NOTICE_OPTION_NAME     = 'notice_review_%s';
	const NOTICE_AJAX_ACTION     = 'fcf_close_notice_review';

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
		add_filter( 'admin_init', [ $this, 'init_review_notice' ] );
		add_action( 'wp_ajax_' . self::NOTICE_AJAX_ACTION, [ $this, 'hide_review_notice' ] );
	}

	/**
	 * Generates admin notice about plugin review.
	 *
	 * @internal
	 */
	public function init_review_notice() {
		$option_notice = sprintf( self::NOTICE_OPTION_NAME, $this->plugin->get_plugin_file_path() );
		$notice_date   = strtotime( get_option( $option_notice, false ) );
		$min_date      = strtotime( current_time( 'mysql' ) );

		if ( ( basename( $_SERVER['PHP_SELF'] ) !== 'index.php' ) // phpcs:ignore
			|| ( ( $notice_date !== false ) && ( $notice_date > $min_date ) ) ) {
			return;
		}

		$option_activation = sprintf( self::ACTIVATION_OPTION_NAME, $this->plugin->get_plugin_file_path() );
		$activation_date   = strtotime( get_option( $option_activation, current_time( 'mysql' ) ) );
		$min_date          = strtotime( current_time( 'mysql' ) . ' -2 weeks' );

		if ( $activation_date > $min_date ) {
			return;
		}

		add_filter( 'admin_notices', [ $this, 'show_review_notice' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_styles_for_notice' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_scripts_for_notice' ] );
	}

	/**
	 * Disables visible notice.
	 *
	 * @internal
	 */
	public function hide_review_notice() {
		$option_name  = sprintf( self::NOTICE_OPTION_NAME, $this->plugin->get_plugin_file_path() );
		$is_permanent = ( isset( $_POST['is_permanently'] ) && $_POST['is_permanently'] ); // phpcs:ignore
		$notice_time  = strtotime( current_time( 'mysql' ) . ( ( $is_permanent ) ? ' +10 years' : ' +1 month' ) );
		$notice_date  = gmdate( 'Y-m-d H:i:s', $notice_time );

		update_option( $option_name, $notice_date, true );
	}

	/**
	 * Displays admin notice about plugin review.
	 *
	 * @internal
	 */
	public function show_review_notice() {
		echo $this->renderer->render( // phpcs:ignore
			'notices/review',
			[
				'ajax_url'    => esc_attr( admin_url( 'admin-ajax.php' ) ),
				'ajax_action' => esc_attr( self::NOTICE_AJAX_ACTION ),
			]
		);
	}

	/**
	 * Enqueues styles in WordPress Admin Dashboard.
	 *
	 * @internal
	 */
	public function load_styles_for_notice() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

		wp_register_style(
			'fcf-notice',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'css/admin-notice' . $suffix,
			[],
			$this->plugin->get_script_version()
		);
		wp_enqueue_style( 'fcf-notice' );
	}

	/**
	 * Enqueues scripts in WordPress Admin Dashboard.
	 *
	 * @internal
	 */
	public function load_scripts_for_notice() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

		wp_register_script(
			'fcf-notice',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'js/admin-notice' . $suffix,
			[],
			$this->plugin->get_script_version(),
			true
		);
		wp_enqueue_script( 'fcf-notice' );
	}

}
