<?php

namespace WPDesk\FCF\Free;

use FcfVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use FcfVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use FcfVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use FcfVendor\WPDesk_Plugin_Info;
use WPDesk\FCF\Free\Admin;
use WPDesk\FCF\Free\Field;
use WPDesk\FCF\Free\Integration;
use WPDesk\FCF\Free\Service;
use WPDesk\FCF\Free\Settings;
use WPDesk\FCF\Free\Tracker;

/**
 * Main plugin class. The most important flow decisions are made here.
 */
class Plugin extends AbstractPlugin implements HookableCollection {

	use HookableParent;

	/**
	 * Scripts version.
	 *
	 * @var string
	 */
	private $script_version = '1';

	/**
	 * Instance of old version main class of plugin.
	 *
	 * @var \Flexible_Checkout_Fields_Plugin
	 */
	private $plugin_old;

	/**
	 * @var Service\TemplateLoader
	 */
	private $template_loader;

	/**
	 * Plugin constructor.
	 *
	 * @param WPDesk_Plugin_Info               $plugin_info Plugin info.
	 * @param \Flexible_Checkout_Fields_Plugin $plugin_old  Main plugin.
	 */
	public function __construct( WPDesk_Plugin_Info $plugin_info, \Flexible_Checkout_Fields_Plugin $plugin_old ) {
		parent::__construct( $plugin_info );

		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();
		$this->script_version   = $plugin_info->get_version();
		$this->plugin_old       = $plugin_old;
		$this->template_loader  = new Service\TemplateLoader( $plugin_info->get_plugin_dir(), 'flexible-checkout-fields' );
	}

	/**
	 * Initializes plugin external state.
	 * The plugin internal state is initialized in the constructor and the plugin should be internally consistent after
	 * creation. The external state includes hooks execution, communication with other plugins, integration with WC
	 * etc.
	 *
	 * @return void
	 */
	public function init() {
		$this->add_hookable( new Service\ShortLinksGenerator() );

		$this->add_hookable( new Admin\NoticeReview() );
		$this->add_hookable( new Settings\Page() );
		$this->add_hookable( new Form\Assets( $this->plugin_info ) );
		$this->add_hookable( new Field\FieldTranslator() );
		$this->add_hookable( new Field\FieldTemplateLoader( $this->template_loader ) );

		$this->add_hookable( new Integration\IntegratorIntegration( $this->plugin_old ) );
		$this->add_hookable( new Tracker\DeactivationTracker( $this->plugin_info ) );

		$this->add_hookable( new Validator\FieldValidator() );
		$this->add_hookable( new Validator\ValidationClassGenerator() );

		( new Field\Types() )->init();
		( new Settings\Forms() )->init();
		( new Settings\Routes() )->init();
		( new Settings\Tabs() )->init();
		$this->add_hookable( new Settings\MigrationsManager( $this->plugin_info->get_version() ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		$this->hooks_on_hookable_objects();
	}

	/**
	 * Get script version.
	 *
	 * @return string;
	 */
	public function get_script_version() {
		return $this->script_version;
	}
}
