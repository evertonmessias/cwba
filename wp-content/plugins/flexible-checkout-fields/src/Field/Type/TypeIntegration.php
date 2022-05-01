<?php

namespace WPDesk\FCF\Free\Field\Type;

/**
 * Initializes integration for REST API route.
 */
class TypeIntegration {

	/**
	 * Class object for field type.
	 *
	 * @var TypeInterface
	 */
	private $type_object;

	/**
	 * Class constructor.
	 *
	 * @param TypeInterface $type_object Class object of field type.
	 */
	public function __construct( TypeInterface $type_object ) {
		$this->type_object = $type_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_checkout_fields/field_types', [ $this, 'add_field_type' ], 0 );
	}

	/**
	 * Adds new field type with settings of field type.
	 *
	 * @param array $types List of field types.
	 *
	 * @return array Updated list of field types.
	 * @internal
	 */
	public function add_field_type( array $types ): array {
		$field_type           = $this->type_object->get_field_type();
		$types[ $field_type ] = $this->get_field_type_settings();
		return $types;
	}

	/**
	 * Returns list of settings for field type.
	 *
	 * @return array Settings of field type.
	 */
	private function get_field_type_settings(): array {
		return [
			'type'                 => $this->type_object->get_field_type(),
			'field_group'          => $this->type_object->get_field_group(),
			'reserved_field_names' => $this->type_object->get_reserved_field_names(),
			'label'                => $this->type_object->get_field_type_label(),
			'icon'                 => $this->type_object->get_field_type_icon(),
			'is_hidden'            => $this->type_object->is_hidden(),
			'is_available'         => $this->type_object->is_available(),
			'options'              => $this->type_object->get_options(),
		];
	}
}
