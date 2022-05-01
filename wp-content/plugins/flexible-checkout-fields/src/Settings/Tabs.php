<?php

namespace WPDesk\FCF\Free\Settings;

use WPDesk\FCF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FCF\Free\Settings\Tab\AppearanceTab;
use WPDesk\FCF\Free\Settings\Tab\DisplayTab;
use WPDesk\FCF\Free\Settings\Tab\GeneralTab;
use WPDesk\FCF\Free\Settings\Tab\LogicTab;
use WPDesk\FCF\Free\Settings\Tab\PricingTab;
use WPDesk\FCF\Free\Settings\Tab\TabIntegration;

/**
 * Supports management for settings tabs of field.
 */
class Tabs {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new TabIntegration( new GeneralTab() ) )->hooks();
		( new TabIntegration( new AdvancedTab() ) )->hooks();
		( new TabIntegration( new AppearanceTab() ) )->hooks();
		( new TabIntegration( new DisplayTab() ) )->hooks();
		( new TabIntegration( new LogicTab() ) )->hooks();
		( new TabIntegration( new PricingTab() ) )->hooks();
	}
}
