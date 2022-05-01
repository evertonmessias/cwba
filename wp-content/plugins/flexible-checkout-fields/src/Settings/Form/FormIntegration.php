<?php

namespace WPDesk\FCF\Free\Settings\Form;

/**
 * Initializes integration for form.
 */
class FormIntegration {

	/**
	 * Class object for field type.
	 *
	 * @var FormInterface
	 */
	private $form_object;

	/**
	 * Class constructor.
	 *
	 * @param FormInterface $form_object Class object of field type.
	 */
	public function __construct( FormInterface $form_object ) {
		$this->form_object = $form_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter(
			'flexible_checkout_fields/form_data_' . $this->form_object->get_form_type(),
			[ $this, 'get_form_data' ],
			10,
			2
		);
		add_filter(
			'flexible_checkout_fields/form_fields_' . $this->form_object->get_form_type(),
			[ $this, 'get_form_fields' ],
			10,
			2
		);
	}

	/**
	 * Returns updated settings for form.
	 *
	 * @param array  $form_data Default settings of form.
	 * @param string $form_key  Key of form.
	 *
	 * @return array Settings of form.
	 * @internal
	 */
	public function get_form_data( array $form_data, string $form_key = '' ): array {
		return $this->form_object->get_form_data( $form_data, $form_key );
	}

	/**
	 * Returns fields of settings for form.
	 *
	 * @param array  $form_fields Default fields of form.
	 * @param string $form_key    Key of form.
	 *
	 * @return array Fields of form.
	 * @internal
	 */
	public function get_form_fields( array $form_fields, string $form_key = '' ): array { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
		return $this->form_object->get_options_list();
	}
}
