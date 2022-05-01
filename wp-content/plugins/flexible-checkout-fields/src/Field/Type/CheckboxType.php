<?php

namespace WPDesk\FCF\Free\Field\Type;

use WPDesk\FCF\Free\Field\Types;
use WPDesk\FCF\Free\Settings\Option\CssOption;
use WPDesk\FCF\Free\Settings\Option\CustomFieldOption;
use WPDesk\FCF\Free\Settings\Option\DefaultOption;
use WPDesk\FCF\Free\Settings\Option\DisplayOnOption;
use WPDesk\FCF\Free\Settings\Option\EnabledOption;
use WPDesk\FCF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FCF\Free\Settings\Option\FormattingOption;
use WPDesk\FCF\Free\Settings\Option\LabelOption;
use WPDesk\FCF\Free\Settings\Option\LogicAdvOption;
use WPDesk\FCF\Free\Settings\Option\NameOption;
use WPDesk\FCF\Free\Settings\Option\PlaceholderCheckboxOption;
use WPDesk\FCF\Free\Settings\Option\PricingAdvOption;
use WPDesk\FCF\Free\Settings\Option\PriorityOption;
use WPDesk\FCF\Free\Settings\Option\RequiredOption;
use WPDesk\FCF\Free\Settings\Tab\AppearanceTab;
use WPDesk\FCF\Free\Settings\Tab\DisplayTab;
use WPDesk\FCF\Free\Settings\Tab\GeneralTab;
use WPDesk\FCF\Free\Settings\Tab\LogicTab;
use WPDesk\FCF\Free\Settings\Tab\PricingTab;

/**
 * {@inheritdoc}
 */
class CheckboxType extends TypeAbstract {

	const FIELD_TYPE = 'inspirecheckbox';

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
		return __( 'Checkbox', 'flexible-checkout-fields' );
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
		return 'icon-check-square';
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME    => [
				PriorityOption::FIELD_NAME            => new PriorityOption(),
				FieldTypeOption::FIELD_NAME           => new FieldTypeOption(),
				CustomFieldOption::FIELD_NAME         => new CustomFieldOption(),
				EnabledOption::FIELD_NAME             => new EnabledOption(),
				RequiredOption::FIELD_NAME            => new RequiredOption(),
				LabelOption::FIELD_NAME               => new LabelOption(),
				PlaceholderCheckboxOption::FIELD_NAME => new PlaceholderCheckboxOption(),
				DefaultOption::FIELD_NAME             => new DefaultOption(),
				NameOption::FIELD_NAME                => new NameOption(),
			],
			AppearanceTab::TAB_NAME => [
				CssOption::FIELD_NAME => new CssOption(),
			],
			DisplayTab::TAB_NAME    => [
				DisplayOnOption::FIELD_NAME  => new DisplayOnOption(),
				FormattingOption::FIELD_NAME => new FormattingOption(),
			],
			LogicTab::TAB_NAME      => [
				LogicAdvOption::FIELD_NAME => new LogicAdvOption(),
			],
			PricingTab::TAB_NAME    => [
				PricingAdvOption::FIELD_NAME => new PricingAdvOption(),
			],
		];
	}
}
