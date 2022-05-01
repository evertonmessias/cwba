<?php

namespace WPDesk\FCF\Free\Settings\Tab;

/**
 * Initializes integration for settings tab of field.
 */
class TabIntegration {

	/**
	 * Class object for field type.
	 *
	 * @var TabInterface
	 */
	private $tab_object;

	/**
	 * Class constructor.
	 *
	 * @param TabInterface $tab_object Class object of field type.
	 */
	public function __construct( TabInterface $tab_object ) {
		$this->tab_object = $tab_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_checkout_fields/field_settings_tabs', [ $this, 'add_settings_tab' ], 0 );
	}

	/**
	 * Adds new tab for field settings.
	 *
	 * @param array $tabs List of field settings tabs.
	 *
	 * @return array Updated list of settings tabs.
	 * @internal
	 */
	public function add_settings_tab( array $tabs ): array {
		$tab_name          = $this->tab_object->get_tab_name();
		$tabs[ $tab_name ] = $this->get_tab_settings();
		return $tabs;
	}

	/**
	 * Returns list of settings for tab.
	 *
	 * @return array Settings of tab.
	 */
	private function get_tab_settings(): array {
		return [
			'name'  => $this->tab_object->get_tab_name(),
			'label' => $this->tab_object->get_tab_label(),
			'icon'  => $this->tab_object->get_tab_icon(),
		];
	}
}
