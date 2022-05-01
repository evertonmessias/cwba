<?php

namespace WPDesk\FCF\Free\Settings\Form;

use WPDesk\FCF\Free\Field\FieldData;
use WPDesk\FCF\Free\Settings\Option\ExternalFieldOption;

/**
 * {@inheritdoc}
 */
class EditFieldsForm extends FormAbstract implements FormInterface {

	const FORM_TYPE            = 'fields';
	const SETTINGS_OPTION_NAME = 'inspire_checkout_fields_settings';

	/**
	 * {@inheritdoc}
	 */
	public function get_form_type(): string {
		return self::FORM_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_form_data( array $form_data, string $form_key = '' ): array {
		$settings       = get_option( self::SETTINGS_OPTION_NAME, [] );
		$section_fields = $this->combine_fields_settings(
			$this->get_section_form_data( $form_key ),
			( $settings[ $form_key ] ?? [] ) ?: []
		);
		if ( ! $section_fields ) {
			return $form_data;
		}

		foreach ( $section_fields as $field_name => $field_data ) {
			$field_data['name'] = $field_name;
			$new_field_data     = FieldData::get_field_data( $field_data );
			if ( ! $new_field_data ) {
				continue;
			}
			$form_data[ $field_name ] = $new_field_data;
		}

		uasort(
			$form_data,
			function ( $a, $b ) {
				if ( ( $a['priority'] ?? 0 ) === 0 ) {
					return 1;
				} elseif ( ( $b['priority'] ?? 0 ) === 0 ) {
					return -1;
				}

				return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
			}
		);

		return $form_data;
	}

	/**
	 * Returns default settings for form of checkout section.
	 *
	 * @param string $section_key Key of section.
	 *
	 * @return array Settings of form.
	 */
	private function get_section_form_data( string $section_key ): array {
		$countries = new \WC_Countries();
		$sections  = [
			'billing'  => $countries->get_address_fields( $countries->get_base_country(), 'billing_' ),
			'shipping' => $countries->get_address_fields( $countries->get_base_country(), 'shipping_' ),
			'order'    => [
				'order_comments' => [
					'type'        => 'textarea',
					'class'       => [ 'notes' ],
					'label'       => __( 'Order Notes', 'flexible-checkout-fields' ),
					'placeholder' => __( 'Notes about your order, e.g. special notes for delivery.', 'flexible-checkout-fields' ),
				],
			],
		];

		$sections += $this->get_custom_sections();
		return $sections[ $section_key ] ?? [];
	}

	/**
	 * Returns list of custom checkout sections.
	 *
	 * @return array List of sections.
	 */
	private function get_custom_sections(): array {
		$custom_sections = apply_filters( 'flexible_checkout_fields_all_sections', [] );

		$sections = [];
		foreach ( $custom_sections as $custom_section ) {
			$sections[ $custom_section['section'] ] = [];
		}
		return $sections;
	}

	/**
	 * Combines default field settings with settings saved by plugin.
	 *
	 * @param array $checkout_fields Default field settings.
	 * @param array $settings_fields Field settings saved by plugin.
	 *
	 * @return array Final field settings.
	 */
	private function combine_fields_settings( array $checkout_fields, array $settings_fields ): array {
		$fields = $checkout_fields;
		foreach ( $fields as $field_name => $field ) {
			if ( ! isset( $settings_fields[ $field_name ] ) ) {
				$fields[ $field_name ][ ExternalFieldOption::FIELD_NAME ] = 1;
			}
		}

		foreach ( $settings_fields as $field_name => $settings_field ) {
			$fields[ $field_name ] = array_merge( $fields[ $field_name ] ?? [], $settings_field );
		}
		return $fields;
	}

	/**
	 * Saves settings for form.
	 *
	 * @param array $params Params for endpoint.
	 *
	 * @return bool Status of process.
	 * @throws \Exception .
	 */
	public function save_form_data( array $params ): bool {
		$posted_fields = [];
		foreach ( $params['form_fields'] as $field ) {
			$posted_fields[ $field['name'] ] = $field;
		}

		$section_fields = [];
		foreach ( $params['form_fields'] as $field_data ) {
			$new_field_data = FieldData::get_field_data( $posted_fields[ $field_data['name'] ], false );
			if ( ! $new_field_data ) {
				continue;
			}
			$section_fields[ $field_data['name'] ] = $new_field_data;
		}

		$settings = get_option( self::SETTINGS_OPTION_NAME, [] ) ?: [];
		if ( ! $section_fields ) {
			if ( isset( $settings[ $params['form_section'] ] ) ) {
				unset( $settings[ $params['form_section'] ] );
			}
		} else {
			$settings[ $params['form_section'] ] = $section_fields;
		}

		update_option( self::SETTINGS_OPTION_NAME, $settings );
		return true;
	}
}
