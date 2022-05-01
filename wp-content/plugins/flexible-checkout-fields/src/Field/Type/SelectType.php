<?php

namespace WPDesk\FCF\Free\Field\Type;

use WPDesk\FCF\Free\Field\Types;
use WPDesk\FCF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FCF\Free\Settings\Option\OptionInterface;
use WPDesk\FCF\Free\Settings\Tab\GeneralTab;

/**
 * {@inheritdoc}
 */
class SelectType extends DefaultType implements TypeInterface {

	const FIELD_TYPE = 'select';

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type(): string {
		return self::FIELD_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_label(): string {
		return __( 'Select', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_group(): string {
		return Types::FIELD_GROUP_OPTION;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_icon(): string {
		return 'icon-tasks-alt';
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_hidden(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available(): bool {
		return false;
	}

	/**
	 * Returns list of options for field settings.
	 *
	 * @return OptionInterface[] List of option fields.
	 */
	public function get_options_objects(): array {
		$options = parent::get_options_objects();

		$options[ GeneralTab::TAB_NAME ][ FieldTypeOption::FIELD_NAME ] = new FieldTypeOption();

		return $options;
	}
}
