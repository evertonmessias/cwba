<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
interface FieldInterface {

	/**
	 * Returns key of field.
	 *
	 * @return string Field key.
	 */
	public function get_field_key(): string;

	/**
	 * Returns label of field.
	 *
	 * @return string Field label.
	 */
	public function get_field_label(): string;

	/**
	 * Returns type of field.
	 *
	 * @return string Field type.
	 */
	public function get_field_type(): string;

	/**
	 * Returns status if field is custom.
	 *
	 * @return bool If field is custom?
	 */
	public function is_custom_field(): bool;

	/**
	 * Returns key of field group.
	 *
	 * @return string Group key.
	 */
	public function get_group_key(): string;
}
