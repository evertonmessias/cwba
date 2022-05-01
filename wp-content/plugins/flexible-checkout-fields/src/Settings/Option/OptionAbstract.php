<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
abstract class OptionAbstract implements OptionInterface {

	const FIELD_TYPE_CHECKBOX      = 'CheckboxField';
	const FIELD_TYPE_CHECKBOX_LIST = 'CheckboxListField';
	const FIELD_TYPE_GROUP         = 'GroupField';
	const FIELD_TYPE_HIDDEN        = 'HiddenField';
	const FIELD_TYPE_INFO          = 'InfoField';
	const FIELD_TYPE_INFO_ADV      = 'InfoAdvField';
	const FIELD_TYPE_INFO_NOTICE   = 'InfoNoticeField';
	const FIELD_TYPE_NUMBER        = 'NumberField';
	const FIELD_TYPE_RADIO         = 'RadioField';
	const FIELD_TYPE_RADIO_LIST    = 'RadioListField';
	const FIELD_TYPE_REPEATER      = 'RepeaterField';
	const FIELD_TYPE_SELECT        = 'SelectField';
	const FIELD_TYPE_SELECT_MULTI  = 'SelectMultiField';
	const FIELD_TYPE_TEXTAREA      = 'TextareaField';
	const FIELD_TYPE_TEXT          = 'TextField';
	const FIELD_TYPE_IMAGE         = 'ImageField';
	const FIELD_TYPE_COLOR         = 'ColorField';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_tab(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_row_label(): string {
		return 'Row #%s';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip_url(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_input_atts(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_print_pattern(): string {
		return '%s';
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_readonly(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_validation_rules(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_regexes_to_display(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name_to_rows(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_route(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_option_names(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_endpoint_autorefreshed(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_refresh_trigger(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function sanitize_option_value( $field_value ) {
		switch ( $this->get_option_type() ) {
			case self::FIELD_TYPE_CHECKBOX:
				return ( $field_value ) ? '1' : '0';
			case self::FIELD_TYPE_RADIO:
			case self::FIELD_TYPE_RADIO_LIST:
			case self::FIELD_TYPE_SELECT:
				$values = $this->get_values();
				if ( $values ) {
					return ( array_key_exists( $field_value, $values ) ) ? $field_value : $this->get_default_value();
				}
				break;
			case self::FIELD_TYPE_SELECT_MULTI:
				if ( ! is_array( $field_value ) ) {
					$field_value = [];
				}

				foreach ( $field_value as $value_index => $value ) {
					$field_value[ $value_index ] = sanitize_text_field( wp_unslash( $value ) );
				}
				return $field_value;
			case self::FIELD_TYPE_CHECKBOX_LIST:
			case self::FIELD_TYPE_GROUP:
			case self::FIELD_TYPE_REPEATER:
				return $field_value;
		}

		return sanitize_text_field( wp_unslash( $field_value ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_field_data( array $field_data, array $field_settings ): array {
		$option_name = $this->get_option_name();

		switch ( $this->get_option_type() ) {
			case self::FIELD_TYPE_CHECKBOX_LIST:
			case self::FIELD_TYPE_GROUP:
				foreach ( $this->get_children() as $option_children ) {
					$field_data = $option_children->update_field_data( $field_data, $field_settings );
				}
				break;
			case self::FIELD_TYPE_REPEATER:
				$rows = $field_settings[ $option_name ] ?? [];
				if ( ! $rows ) {
					return $field_data;
				}

				foreach ( (array) $rows as $row_index => $row ) {
					if ( ! $row ) {
						continue;
					}

					foreach ( $this->get_children() as $option_children ) {
						$field_data[ $option_name ][ $row_index ] = $option_children->update_field_data(
							$field_data[ $option_name ][ $row_index ] ?? [],
							$row
						);
					}
				}
				$field_data[ $option_name ] = $this->sanitize_option_value(
					$field_data[ $option_name ] ?? $this->get_default_value()
				);
				break;
			default:
				$field_data[ $option_name ] = $this->sanitize_option_value(
					$field_settings[ $option_name ] ?? $this->get_default_value()
				);
				break;
		}

		return $field_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_field_data( array $field_data, array $field_settings ): array {
		return $this->update_field_data( $field_data, $field_settings );
	}
}
