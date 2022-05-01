<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
class Field implements FieldInterface {

	/**
	 * Settings of field.
	 *
	 * @var array
	 */
	private $field_data;

	/**
	 * Key of field group.
	 *
	 * @var string
	 */
	private $field_group;

	/**
	 * Class constructor.
	 *
	 * @param array  $field_data  Settings of field.
	 * @param string $field_group Key of field group.
	 */
	public function __construct( array $field_data, string $field_group ) {
		$this->field_data  = $field_data;
		$this->field_group = $field_group;
	}

	/**
	 * Returns key of field.
	 *
	 * @return string Field key.
	 */
	public function get_field_key(): string {
		return $this->field_data['name'];
	}

	/**
	 * Returns type of field.
	 *
	 * @return string Field type, if known.
	 */
	public function get_field_type(): string {
		return $this->field_data['type'] ?? '';
	}

	/**
	 * Returns label of field.
	 *
	 * @return string Field label.
	 */
	public function get_field_label(): string {
		return $this->field_data['label'];
	}

	/**
	 * Returns status if field is custom.
	 *
	 * @return bool If field is custom?
	 */
	public function is_custom_field(): bool {
		return ( isset( $this->field_data['custom_field'] ) && $this->field_data['custom_field'] );
	}

	/**
	 * Returns key of field group.
	 *
	 * @return string Group key.
	 */
	public function get_group_key(): string {
		return $this->field_group;
	}
}
