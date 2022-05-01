<?php

namespace WPDesk\FCF\Free\Field\Type;

use WPDesk\FCF\Free\Field\Types;
use WPDesk\FCF\Free\Settings\Option\CssOption;
use WPDesk\FCF\Free\Settings\Option\CustomFieldOption;
use WPDesk\FCF\Free\Settings\Option\DisplayOnOption;
use WPDesk\FCF\Free\Settings\Option\EnabledOption;
use WPDesk\FCF\Free\Settings\Option\ExternalFieldInfoOption;
use WPDesk\FCF\Free\Settings\Option\ExternalFieldOption;
use WPDesk\FCF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FCF\Free\Settings\Option\FormattingOption;
use WPDesk\FCF\Free\Settings\Option\LabelOption;
use WPDesk\FCF\Free\Settings\Option\LogicAdvOption;
use WPDesk\FCF\Free\Settings\Option\NameOption;
use WPDesk\FCF\Free\Settings\Option\OptionInterface;
use WPDesk\FCF\Free\Settings\Option\PlaceholderOption;
use WPDesk\FCF\Free\Settings\Option\PricingAdvOption;
use WPDesk\FCF\Free\Settings\Option\PriorityOption;
use WPDesk\FCF\Free\Settings\Option\RequiredOption;
use WPDesk\FCF\Free\Settings\Option\ValidationInfoOption;
use WPDesk\FCF\Free\Settings\Option\ValidationOption;
use WPDesk\FCF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FCF\Free\Settings\Tab\AppearanceTab;
use WPDesk\FCF\Free\Settings\Tab\DisplayTab;
use WPDesk\FCF\Free\Settings\Tab\GeneralTab;
use WPDesk\FCF\Free\Settings\Tab\LogicTab;
use WPDesk\FCF\Free\Settings\Tab\PricingTab;

/**
 * {@inheritdoc}
 */
class EmailType extends TypeAbstract {

	const FIELD_TYPE = 'email';

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
		return __( 'E-mail', 'flexible-checkout-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_group(): string {
		return Types::FIELD_GROUP_TEXT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_icon(): string {
		return 'icon-at-email';
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available(): bool {
		return true;
	}

	/**
	 * Returns list of options for field settings.
	 *
	 * @return OptionInterface[] List of option fields.
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME    => [
				ExternalFieldInfoOption::FIELD_NAME => new ExternalFieldInfoOption(),
				PriorityOption::FIELD_NAME          => new PriorityOption(),
				FieldTypeOption::FIELD_NAME         => new FieldTypeOption(),
				EnabledOption::FIELD_NAME           => new EnabledOption(),
				CustomFieldOption::FIELD_NAME       => new CustomFieldOption(),
				ExternalFieldOption::FIELD_NAME     => new ExternalFieldOption(),
				RequiredOption::FIELD_NAME          => new RequiredOption(),
				LabelOption::FIELD_NAME             => new LabelOption(),
				NameOption::FIELD_NAME              => new NameOption(),
			],
			AdvancedTab::TAB_NAME   => [
				ValidationOption::FIELD_NAME     => new ValidationOption(),
				ValidationInfoOption::FIELD_NAME => new ValidationInfoOption(),
			],
			AppearanceTab::TAB_NAME => [
				PlaceholderOption::FIELD_NAME => new PlaceholderOption(),
				CssOption::FIELD_NAME         => new CssOption(),
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
