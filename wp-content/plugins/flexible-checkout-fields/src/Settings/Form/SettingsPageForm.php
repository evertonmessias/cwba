<?php

namespace WPDesk\FCF\Free\Settings\Form;

use WPDesk\FCF\Free\Settings\Option\OptionIntegration;
use WPDesk\FCF\Free\Settings\Option\OptionInterface;
use WPDesk\FCF\Free\Settings\Option\SettingJqueryOption;
use WPDesk\FCF\Free\Settings\Option\SettingSectionsAdvOption;

/**
 * {@inheritdoc}
 */
class SettingsPageForm extends FormAbstract implements FormInterface {

	const FORM_TYPE = 'settings';

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
		$section_fields = [];

		$options = ( new SettingJqueryOption() )->get_children();
		foreach ( $options as $option ) {
			$option_status                                = get_option( $option->get_option_name(), 0 );
			$section_fields[ $option->get_option_name() ] = ( $option_status ) ? '1' : '0';
		}

		$option_objects = $this->get_options_list();
		foreach ( $option_objects as $field_option ) {
			$form_data = $field_option['update_field_callback'](
				$form_data,
				$section_fields
			);
		}

		return $form_data;
	}

	/**
	 * Returns list of option objects.
	 *
	 * @return OptionInterface[] List of options.
	 */
	public function get_options_list(): array {
		return [
			( new OptionIntegration( new SettingJqueryOption() ) )->get_field_settings(),
			( new OptionIntegration( new SettingSectionsAdvOption() ) )->get_field_settings(),
		];
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
		$settings_options = [];

		$option_objects = $this->get_options_list();
		foreach ( $option_objects as $field_option ) {
			$settings_options = $field_option['save_field_callback'](
				$settings_options,
				$params['form_fields']
			);
		}

		foreach ( $settings_options as $option => $option_status ) {
			update_option( $option, ( $option_status ) ? '1' : '0', true );
		}

		return true;
	}
}
