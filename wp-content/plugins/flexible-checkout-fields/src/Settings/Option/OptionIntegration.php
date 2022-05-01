<?php

namespace WPDesk\FCF\Free\Settings\Option;

/**
 * Initializes integration for option of field.
 */
class OptionIntegration {

	/**
	 * Class object for field type.
	 *
	 * @var OptionInterface
	 */
	private $option_object;

	/**
	 * Class constructor.
	 *
	 * @param OptionInterface $option_object Class object of field type.
	 */
	public function __construct( OptionInterface $option_object ) {
		$this->option_object = $option_object;
	}

	/**
	 * Returns list of settings for field.
	 *
	 * @return array Settings of field.
	 */
	public function get_field_settings(): array {
		$settings = [
			'name'                  => $this->option_object->get_option_name(),
			'type'                  => $this->option_object->get_option_type(),
			'tab_name'              => $this->option_object->get_option_tab(),
			'label'                 => $this->option_object->get_option_label(),
			'label_row'             => $this->option_object->get_option_row_label(),
			'label_tooltip'         => $this->option_object->get_label_tooltip(),
			'label_tooltip_url'     => $this->option_object->get_label_tooltip_url(),
			'html_atts'             => $this->option_object->get_input_atts(),
			'display_pattern'       => $this->option_object->get_print_pattern(),
			'readonly'              => $this->option_object->is_readonly(),
			'validation_rules'      => array_map(
				function ( string $validation_regex, string $validation_message ) {
					return [
						'regex'    => $validation_regex,
						'message'  => $validation_message,
						'is_fatal' => true,
					];
				},
				array_keys( $this->option_object->get_validation_rules() ),
				$this->option_object->get_validation_rules()
			),
			'option_name_rows'      => $this->option_object->get_option_name_to_rows(),
			'default_value'         => $this->option_object->get_default_value(),
			'show_if_regexes'       => $this->option_object->get_options_regexes_to_display(),
			'refresh_trigger'       => $this->option_object->is_refresh_trigger(),
			'endpoint_route'        => $this->option_object->get_endpoint_route(),
			'endpoint_params'       => $this->option_object->get_endpoint_option_names(),
			'endpoint_autorefresh'  => $this->option_object->is_endpoint_autorefreshed(),
			'update_field_callback' => [ $this->option_object, 'update_field_data' ],
			'save_field_callback'   => [ $this->option_object, 'save_field_data' ],
			'items'                 => [],
		];

		switch ( $settings['type'] ) {
			case OptionAbstract::FIELD_TYPE_CHECKBOX_LIST:
			case OptionAbstract::FIELD_TYPE_GROUP:
			case OptionAbstract::FIELD_TYPE_REPEATER:
				foreach ( $this->option_object->get_children() as $child_object ) {
					$settings['items'][] = ( new OptionIntegration( $child_object ) )->get_field_settings();
				}
				break;
			case OptionAbstract::FIELD_TYPE_RADIO:
			case OptionAbstract::FIELD_TYPE_SELECT:
			case OptionAbstract::FIELD_TYPE_SELECT_MULTI:
				$settings['items'] = $this->option_object->get_values();
				break;
		}

		return $settings;
	}
}
