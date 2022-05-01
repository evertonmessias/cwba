<?php

namespace WPDesk\FCF\Free\Settings\Tab;

/**
 * Interface for settings tab of field.
 */
interface TabInterface {

	/**
	 * Returns name of tab.
	 *
	 * @return string Tab name.
	 */
	public function get_tab_name(): string;

	/**
	 * Returns label of tab.
	 *
	 * @return string Tab label.
	 */
	public function get_tab_label(): string;

	/**
	 * Returns tab icon as CSS Class supported by Icomoon.
	 *
	 * @return string Tab icon.
	 */
	public function get_tab_icon(): string;
}
