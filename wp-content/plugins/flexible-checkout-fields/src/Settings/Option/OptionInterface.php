<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * Interface for option of field.
 */
interface OptionInterface {

	/**
	 * Returns name of option.
	 *
	 * @return string Option name.
	 */
	public function get_option_name(): string;

	/**
	 * Returns name of option tab.
	 *
	 * @return string Tab name.
	 */
	public function get_option_tab(): string;

	/**
	 * Returns type of option.
	 *
	 * @return string Option name.
	 */
	public function get_option_type(): string;

	/**
	 * Returns label of option.
	 *
	 * @return string Option label.
	 */
	public function get_option_label(): string;

	/**
	 * Returns label of option row (for Repeater field).
	 *
	 * @return string Option row label.
	 */
	public function get_option_row_label(): string;

	/**
	 * Returns content for label tooltip.
	 *
	 * @return string Tooltip content.
	 */
	public function get_label_tooltip(): string;

	/**
	 * Returns URL for label tooltip.
	 *
	 * @return string Tooltip URL.
	 */
	public function get_label_tooltip_url(): string;

	/**
	 * Returns list of HTML attributes for field with their values.
	 *
	 * @return array Atts for field.
	 */
	public function get_input_atts(): array;

	/**
	 * Returns pattern to display value (%s will be replaced by option value).
	 * It works only for text or textarea fields.
	 *
	 * @return string Pattern to display value.
	 */
	public function get_print_pattern(): string;

	/**
	 * Returns status if option are readonly.
	 *
	 * @return bool Readonly status of option.
	 */
	public function is_readonly(): bool;

	/**
	 * Returns list of validation rules for field.
	 * Key is regular expression without delimiters, value is message of validation error.
	 *
	 * @return array Validation rules.
	 */
	public function get_validation_rules(): array;

	/**
	 * Returns name of option and regex for its value that must be true to display this field.
	 * Key is name of field, value is regular expression without delimiters.
	 *
	 * @return array Option names with regexes.
	 */
	public function get_options_regexes_to_display(): array;

	/**
	 * Returns name of option whose value will create list of rows for Repeater field.
	 *
	 * @return string Option name.
	 */
	public function get_option_name_to_rows(): string;

	/**
	 * Returns available values of option, if exists.
	 *
	 * @return array List of option values.
	 */
	public function get_values(): array;

	/**
	 * Returns default value of option.
	 *
	 * @return string|array Default value.
	 */
	public function get_default_value();

	/**
	 * Returns endpoint route to retrieve values.
	 *
	 * @return string Route name of endpoint.
	 */
	public function get_endpoint_route(): string;

	/**
	 * Returns option names passed to REST API to retrieve values.
	 *
	 * @return array Option keys.
	 */
	public function get_endpoint_option_names(): array;

	/**
	 * Returns status if values from endpoint should be refreshed automatically (triggered by refresh event).
	 *
	 * @return bool Status of auto-refreshed values.
	 */
	public function is_endpoint_autorefreshed(): bool;

	/**
	 * Returns status whether change of option value initiates refresh event.
	 *
	 * @return bool Status of refresh event.
	 */
	public function is_refresh_trigger(): bool;

	/**
	 * Returns subfields of option, if exists.
	 *
	 * @return OptionInterface[] List of option children.
	 */
	public function get_children(): array;

	/**
	 * Filters option value from all unsafe strings.
	 *
	 * @param string|array $field_value Original option value.
	 *
	 * @return string|array Updated value of option.
	 */
	public function sanitize_option_value( $field_value );

	/**
	 * Returns updated settings of field contain values for this option.
	 *
	 * @param array $field_data     Original settings of field.
	 * @param array $field_settings Settings of field.
	 *
	 * @return array Updated settings of field.
	 */
	public function update_field_data( array $field_data, array $field_settings ): array;

	/**
	 * Returns updated settings of field contain submitted values.
	 *
	 * @param array $field_data     Current settings of field.
	 * @param array $field_settings Settings of field.
	 *
	 * @return array Updated settings of field.
	 */
	public function save_field_data( array $field_data, array $field_settings ): array;
}
