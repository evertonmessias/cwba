<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
class Section implements SectionInterface {

	/**
	 * Settings of field section.
	 *
	 * @var array
	 */
	private $section_data;

	/**
	 * Class constructor.
	 *
	 * @param array $section_data Settings of field section.
	 */
	public function __construct( array $section_data ) {
		$this->section_data = $section_data;
	}

	/**
	 * Returns key of field section.
	 *
	 * @return string Section key.
	 */
	public function get_section_key(): string {
		return $this->section_data['section'];
	}

	/**
	 * Returns label of field section.
	 *
	 * @return string Section label.
	 */
	public function get_section_label(): string {
		return $this->section_data['tab_title'];
	}
}
