<?php

namespace WPDesk\FCF\Free\Settings\Form;

/**
 * Interface for form settings.
 */
interface FormInterface {

	/**
	 * Returns type of form.
	 *
	 * @return string Type of form.
	 */
	public function get_form_type(): string;

	/**
	 * Returns basic settings for form.
	 *
	 * @param array  $form_data Default settings of form.
	 * @param string $form_key  Key of form.
	 *
	 * @return array Settings of form.
	 */
	public function get_form_data( array $form_data, string $form_key = '' ): array;

	/**
	 * Saves settings for form.
	 *
	 * @param array $params Params for endpoint.
	 *
	 * @return bool Status of process.
	 */
	public function save_form_data( array $params ): bool;
}
