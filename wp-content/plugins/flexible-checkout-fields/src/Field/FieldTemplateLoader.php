<?php

namespace WPDesk\FCF\Free\Field;

use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\FCF\Free\Exception\TemplateLoadingFailed;
use WPDesk\FCF\Free\Service\TemplateLoader;
use WPDesk\FCF\Free\Settings\Form\EditFieldsForm;
use WPDesk\FCF\Free\Settings\Option\CustomFieldOption;
use WPDesk\FCF\Free\Settings\Option\FieldTypeOption;

/**
 * .
 */
class FieldTemplateLoader implements Hookable {

	/**
	 * @var TemplateLoader
	 */
	private $template_loader;

	/**
	 * Class constructor.
	 */
	public function __construct( TemplateLoader $template_loader ) {
		$this->template_loader = $template_loader;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'woocommerce_form_field', [ $this, 'load_field_template' ], 999, 4 );
		add_filter( 'flexible_checkout_fields_form_field', [ $this, 'load_field_template' ], 10, 4 );
		add_filter( 'woocommerce_form_field_args', [ $this, 'load_default_field_args' ], 10, 1 );
	}

	/**
	 * @param string $output HTML output.
	 * @param string $key    Field name.
	 * @param array  $args   Fields args.
	 * @param mixed  $value  .
	 *
	 * @return string
	 *
	 * @throws TemplateLoadingFailed
	 * @internal
	 */
	public function load_field_template( $output, $key, $args, $value ) {
		if ( ! isset( $args[ CustomFieldOption::FIELD_NAME ] ) || ! $args[ CustomFieldOption::FIELD_NAME ] ) {
			return $output;
		}

		$field_data = $this->get_field_data( $key );
		if ( $field_data === null ) {
			return $output;
		}

		$field_type  = $args[ FieldTypeOption::FIELD_NAME ];
		$field_types = apply_filters( 'flexible_checkout_fields/field_types', [] );
		if ( ! isset( $field_types[ $field_type ] ) || ! $field_types[ $field_type ]['is_available'] ) {
			return $output;
		}

		remove_filter( 'woocommerce_form_field', [ $this, 'load_field_template' ], 999 );

		$output = $this->template_loader->load_template(
			'fields/' . $field_type,
			[
				'args'              => apply_filters( 'flexible_checkout_fields_field_args', $field_data, $key ),
				'key'               => $key,
				'value'             => $value,
				'custom_attributes' => apply_filters( 'flexible_checkout_fields_custom_attributes', [], $field_data ),
			]
		);

		add_filter( 'woocommerce_form_field', [ $this, 'load_field_template' ], 999, 4 );
		return $output;
	}

	/**
	 * @param string $field_name .
	 *
	 * @return mixed|null
	 */
	private function get_field_data( string $field_name ) {
		$fields_settings = get_option( EditFieldsForm::SETTINGS_OPTION_NAME, [] );

		foreach ( $fields_settings as $group_name => $fields ) {
			foreach ( $fields as $field_id => $field_data ) {
				if ( $field_id === $field_name ) {
					return $field_data;
				}
			}
		}
		return null;
	}

	/**
	 * @param array $args .
	 *
	 * @return array
	 * @internal
	 */
	public function load_default_field_args( $args ) {
		if ( ! isset( $args[ CustomFieldOption::FIELD_NAME ] ) || ! $args[ CustomFieldOption::FIELD_NAME ] ) {
			return $args;
		}

		$args['options'] = [];
		return $args;
	}
}
