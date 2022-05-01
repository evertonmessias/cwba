<?php

namespace WPDesk\FCF\Free\Settings;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\FCF\Free\Settings\Migrations\Migration;
use WPDesk\FCF\Free\Settings\Migrations\Migration320;

/**
 * Manage migration of plugin settings after plugin update.
 */
class MigrationsManager implements Hookable {

	const PLUGIN_MIGRATION_OPTION_KEY = 'fcf_migration_version';

	/**
	 * @var string
	 */
	private $plugin_version;

	/**
	 * @var Migration[]
	 */
	private $migrations = [];

	public function __construct( string $plugin_version ) {
		$this->plugin_version = $plugin_version;

		$this->migrations[] = new Migration320();
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'init', [ $this, 'make_migrations' ] );
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function make_migrations() {
		$current_migration = get_option( self::PLUGIN_MIGRATION_OPTION_KEY, '1.0.0' );
		if ( $current_migration === $this->plugin_version ) {
			return;
		}

		foreach ( $this->migrations as $migration ) {
			if ( $migration->get_version() > $this->plugin_version ) {
				$migration->down();
			} elseif ( $migration->get_version() > $current_migration ) {
				$migration->up();
			}
		}

		update_option( self::PLUGIN_MIGRATION_OPTION_KEY, $this->plugin_version );
	}
}
