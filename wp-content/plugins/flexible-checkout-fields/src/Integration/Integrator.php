<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
class Integrator implements IntegratorInterface {

	/**
	 * Major version of integration script.
	 *
	 * @var int
	 */
	const INTEGRATOR_VERSION = 1000;

	/**
	 * Version of plugin.
	 *
	 * @var string
	 */
	private $version_plugin = FLEXIBLE_CHECKOUT_FIELDS_VERSION;

	/**
	 * Version of plugin core (for compatibility with dependent plugins).
	 *
	 * @var string
	 */
	private $version_dev = FLEXIBLE_CHECKOUT_FIELDS_VERSION_DEV;

	/**
	 * List of field sections.
	 *
	 * @var array
	 */
	private $field_sections;

	/**
	 * List of field groups.
	 *
	 * @var array
	 */
	private $field_groups;

	/**
	 * Class constructor.
	 *
	 * @param array $field_sections List of field sections.
	 * @param array $field_groups   List of field groups.
	 */
	public function __construct( array $field_sections, array $field_groups ) {
		$this->field_sections = $field_sections;
		$this->field_groups   = $field_groups;
	}

	/**
	 * Returns version of integration script.
	 *
	 * @return string Integration script version.
	 * @example Use method to integration with plugin.
	 */
	public function get_version(): string {
		$version_major = explode( '.', $this->version_plugin )[0];
		$version_minor = explode( '.', $this->version_plugin )[1];
		$version_patch = explode( '.', $this->version_plugin )[2];

		return sprintf(
			'%d.%d.%d',
			self::INTEGRATOR_VERSION,
			( ( $version_major * 1000 ) + $version_minor ),
			$version_patch
		);
	}

	/**
	 * Returns version of plugin core (do not use this method for plugin integration).
	 *
	 * @return string Plugin core version.
	 * @example Use method to create plugin dependent on this plugin.
	 */
	public function get_version_dev(): string {
		$version_dev_major = explode( '.', $this->version_dev )[0];
		$version_dev_minor = explode( '.', $this->version_dev )[1];
		$version_major     = explode( '.', $this->version_plugin )[0];
		$version_minor     = explode( '.', $this->version_plugin )[1];

		return sprintf(
			'%d.%d.%d',
			$version_dev_major,
			$version_dev_minor,
			( ( $version_major * 1000 ) + $version_minor )
		);
	}

	/**
	 * Returns list of available field sections.
	 *
	 * @return SectionInterface[] List of objects with section data.
	 */
	public function get_available_field_sections(): array {
		return ( new Sections( $this->field_sections ) )->get_available_field_sections();
	}

	/**
	 * Returns list of available fields.
	 *
	 * @param string $group_key Optionally key of field group.
	 *
	 * @return FieldInterface[] List of objects with field data.
	 */
	public function get_available_fields( string $group_key = '' ): array {
		return ( new Fields( $this->field_groups ) )->get_available_fields( $group_key );
	}

	/**
	 * Returns value of order field.
	 *
	 * @param string $field_key Field key.
	 * @param int    $order_id  ID of WC_Order.
	 *
	 * @return mixed Value of field, or null if not exists.
	 */
	public function get_field_value( string $field_key, int $order_id ) {
		return ( new Value() )->get_field_value( $field_key, $order_id );
	}
}
