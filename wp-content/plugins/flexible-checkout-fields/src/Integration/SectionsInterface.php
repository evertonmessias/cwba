<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
interface SectionsInterface {

	/**
	 * Returns list of field sections.
	 *
	 * @return array Field sections.
	 */
	public function get_available_field_sections(): array;
}
