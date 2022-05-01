<?php

namespace WPDesk\FCF\Free\Settings\Migrations;

interface Migration {

	/**
	 * @return string
	 */
	public function get_version(): string;

	/**
	 * Performs migration operations.
	 *
	 * @return void
	 */
	public function up();

	/**
	 * Rolls back migration operations.
	 *
	 * @return void
	 */
	public function down();
}
