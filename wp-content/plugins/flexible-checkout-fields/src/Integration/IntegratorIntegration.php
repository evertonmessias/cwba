<?php

namespace WPDesk\FCF\Free\Integration;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FcfVendor\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use FcfVendor\WPDesk\PluginBuilder\Plugin\PluginAccess;

/**
 * .
 */
class IntegratorIntegration implements Hookable, HookablePluginDependant {

	use PluginAccess;

	/**
	 * Instance of old version main class of plugin.
	 *
	 * @var \Flexible_Checkout_Fields_Plugin
	 */
	private $plugin_old;

	/**
	 * Class constructor.
	 *
	 * @param \Flexible_Checkout_Fields_Plugin $plugin_old Main plugin.
	 */
	public function __construct( \Flexible_Checkout_Fields_Plugin $plugin_old ) {
		$this->plugin_old = $plugin_old;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'init', [ $this, 'set_hook_for_integration' ], 0 );
	}

	/**
	 * Initializes integration for 3rd party plugins.
	 *
	 * @internal
	 */
	public function set_hook_for_integration() {
		$sections = $this->plugin_old->sections ?? [];
		$settings = $this->plugin_old->get_settings();

		do_action(
			'flexible_checkout_fields/init',
			( new Integrator( $sections, $settings ) )
		);
	}
}
