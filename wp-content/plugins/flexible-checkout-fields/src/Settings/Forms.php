<?php

namespace WPDesk\FCF\Free\Settings;

use WPDesk\FCF\Free\Settings\Form\EditFieldsForm;
use WPDesk\FCF\Free\Settings\Form\FormIntegration;
use WPDesk\FCF\Free\Settings\Form\SettingsPageForm;

/**
 * Supports management for forms.
 */
class Forms {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new FormIntegration( new EditFieldsForm() ) )->hooks();
		( new FormIntegration( new SettingsPageForm() ) )->hooks();
	}
}
