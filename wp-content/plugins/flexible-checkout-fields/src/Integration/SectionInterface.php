<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
interface SectionInterface {

	/**
	 * Returns key of field section.
	 *
	 * @return string Section key.
	 */
	public function get_section_key(): string;

	/**
	 * Returns label of field section.
	 *
	 * @return string Section label.
	 */
	public function get_section_label(): string;
}
