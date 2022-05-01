<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
class Sections implements SectionsInterface {

	/**
	 * List of field sections.
	 *
	 * @var array
	 */
	private $field_sections;

	/**
	 * Class constructor.
	 *
	 * @param array $field_sections List of field sections.
	 */
	public function __construct( array $field_sections ) {
		$this->field_sections = $field_sections;
	}

	/**
	 * Returns list of available field sections.
	 *
	 * @return SectionInterface[] List of objects with section data.
	 */
	public function get_available_field_sections(): array {
		$items = [];
		foreach ( $this->field_sections as $section ) {
			$items[] = new Section( $section );
		}

		return $items;
	}
}
