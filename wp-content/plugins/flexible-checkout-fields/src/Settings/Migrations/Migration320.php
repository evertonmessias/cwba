<?php

namespace WPDesk\FCF\Free\Settings\Migrations;

use WPDesk\FCF\Free\Field\Type\FileType;
use WPDesk\FCF\Free\Field\Type\MultiSelectType;
use WPDesk\FCF\Free\Field\Type\RadioType;
use WPDesk\FCF\Free\Field\Type\SelectType;
use WPDesk\FCF\Free\Settings\Form\EditFieldsForm;

/**
 * {@inheritdoc}
 */
class Migration320 implements Migration {

	/**
	 * {@inheritdoc}
	 */
	public function get_version(): string {
		return '3.2.0';
	}

	/**
	 * {@inheritdoc}
	 */
	public function up() {
		$plugin_settings = get_option( EditFieldsForm::SETTINGS_OPTION_NAME, [] );

		foreach ( $plugin_settings as $section_id => $section_fields ) {
			foreach ( $section_fields as $field_id => $field_data ) {
				switch ( $field_data['type'] ?? '' ) {
					case RadioType::FIELD_TYPE:
					case SelectType::FIELD_TYPE:
					case MultiSelectType::FIELD_TYPE:
						$field_data = $this->convert_option_string_to_options_array( $field_data );
						break;
					case FileType::FIELD_TYPE:
						$field_data = $this->convert_extensions_to_mime_types( $field_data );
						break;
				}

				$plugin_settings[ $section_id ][ $field_id ] = $field_data;
			}
		}

		update_option( EditFieldsForm::SETTINGS_OPTION_NAME, $plugin_settings );
	}

	/**
	 * {@inheritdoc}
	 */
	public function down() {
		$plugin_settings = get_option( EditFieldsForm::SETTINGS_OPTION_NAME, [] );

		foreach ( $plugin_settings as $section_id => $section_fields ) {
			foreach ( $section_fields as $field_id => $field_data ) {
				switch ( $field_data['type'] ?? '' ) {
					case RadioType::FIELD_TYPE:
					case SelectType::FIELD_TYPE:
					case MultiSelectType::FIELD_TYPE:
						$field_data = $this->convert_options_array_to_option_string( $field_data );
						break;
					case FileType::FIELD_TYPE:
						$field_data = $this->convert_mime_types_to_extensions( $field_data );
						break;
				}

				$plugin_settings[ $section_id ][ $field_id ] = $field_data;
			}
		}

		update_option( EditFieldsForm::SETTINGS_OPTION_NAME, $plugin_settings );
	}

	/**
	 * Converts "value1 : Value 1\nvalue2 : Value 2" to array structure.
	 */
	private function convert_option_string_to_options_array( array $field_data ): array {
		if ( isset( $field_data['options'] ) ) {
			return $field_data;
		}

		$options = explode( "\n", $field_data['option'] ?? '' );
		$rows    = [];
		foreach ( $options as $option ) {
			$values = explode( ':', $option );
			if ( ! $values ) {
				continue;
			}

			$rows[] = [
				'key'   => trim( $values[0] ),
				'value' => trim( implode( ':', array_slice( $values, 1 ) ) ),
			];
		}

		$field_data['options'] = $rows;
		if ( isset( $field_data['option'] ) ) {
			unset( $field_data['option'] );
		}

		return $field_data;
	}

	/**
	 * Converts array structure to "value1 : Value 1\nvalue2 : Value 2".
	 */
	private function convert_options_array_to_option_string( array $field_data ): array {
		if ( isset( $field_data['option'] ) ) {
			return $field_data;
		}

		$options = $field_data['options'] ?? [];
		$rows    = [];
		foreach ( $options as $option ) {
			$rows[] = sprintf( '%1$s : %2$s', $option['key'], $option['value'] );
		}

		$field_data['option'] = implode( "\n", $rows );
		if ( isset( $field_data['options'] ) ) {
			unset( $field_data['options'] );
		}

		return $field_data;
	}

	/**
	 * Converts "jpg,pdf" to "image/jpeg,application/pdf".
	 */
	private function convert_extensions_to_mime_types( array $field_data ): array {
		$values      = array_map( 'trim', explode( ',', $field_data['file_types'] ?? '' ) );
		$mime_types  = wp_get_mime_types();
		$mime_values = [];
		foreach ( $mime_types as $mime_extensions => $mime_type ) {
			foreach ( explode( '|', $mime_extensions ) as $mime_extension ) {
				$mime_values[ $mime_extension ] = $mime_type;
			}
		}

		$new_values = [];
		foreach ( $values as $value ) {
			if ( in_array( $value, $mime_values, true ) ) {
				$new_values[] = $value;
			} elseif ( isset( $mime_values[ $value ] ) ) {
				$new_values[] = $mime_values[ $value ];
			}
		}

		$field_data['file_types'] = implode( ',', array_unique( $new_values ) );
		return $field_data;
	}

	/**
	 * Converts "image/jpeg,application/pdf" to "jpg,jpeg,jpe,pdf".
	 */
	private function convert_mime_types_to_extensions( array $field_data ): array {
		$values      = array_map( 'trim', explode( ',', $field_data['file_types'] ?? '' ) );
		$mime_types  = wp_get_mime_types();
		$mime_values = [];
		foreach ( $mime_types as $mime_extensions => $mime_type ) {
			$mime_values[ $mime_type ] = explode( '|', $mime_extensions );
		}

		$new_values = [];
		foreach ( $values as $value ) {
			if ( isset( $mime_values[ $value ] ) ) {
				$new_values[] = implode( ',', $mime_values[ $value ] );
			} else {
				$new_values[] = $value;
			}
		}

		$field_data['file_types'] = implode( ',', array_unique( $new_values ) );
		return $field_data;
	}
}
