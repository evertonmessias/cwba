<?php

namespace WPDesk\FCF\Free\Field\Type;

use WPDesk\FCF\Free\Settings\Option\OptionInterface;

/**
 * Interface of field type.
 */
interface TypeInterface {

	/**
	 * Returns value of field type.
	 *
	 * @return string Field type.
	 */
	public function get_field_type(): string;

	/**
	 * Returns value of field type used in HTML.
	 *
	 * @return string Field type.
	 */
	public function get_raw_field_type(): string;

	/**
	 * Returns reserved field names, overriding this field type for selected field names.
	 *
	 * @return array Field names.
	 */
	public function get_reserved_field_names(): array;

	/**
	 * Returns label of field type.
	 *
	 * @return string Field label.
	 */
	public function get_field_type_label(): string;

	/**
	 * Returns key of field group.
	 *
	 * @return string|null
	 */
	public function get_field_group();

	/**
	 * Returns field icon as CSS Class supported by Icomoon.
	 *
	 * @return string Field icon.
	 */
	public function get_field_type_icon(): string;

	/**
	 * Returns whether field type is hidden.
	 *
	 * @return bool Status if field type is hidden.
	 */
	public function is_hidden(): bool;

	/**
	 * Returns whether field type is available for plugin version.
	 *
	 * @return bool Status if field type is available.
	 */
	public function is_available(): bool;

	/**
	 * Returns list of options objects for field settings.
	 *
	 * @return OptionInterface[] List of field options objects.
	 */
	public function get_options_objects(): array;

	/**
	 * Returns list of options for field settings.
	 *
	 * @return array List of field options.
	 */
	public function get_options(): array;
}
