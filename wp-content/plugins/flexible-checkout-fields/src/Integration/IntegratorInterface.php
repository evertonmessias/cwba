<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
interface IntegratorInterface extends SectionsInterface, FieldsInterface, ValueInterface {

	/**
	 * Returns version of integration script.
	 *
	 * @return string Integration script version.
	 * @example Use method to integration with plugin.
	 */
	public function get_version(): string;

	/**
	 * Returns version of plugin core (do not use this method for plugin integration).
	 *
	 * @return string Plugin core version.
	 * @example Use method to create plugin dependent on this plugin.
	 */
	public function get_version_dev(): string;
}
