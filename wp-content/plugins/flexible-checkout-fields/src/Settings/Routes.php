<?php

namespace WPDesk\FCF\Free\Settings;

use WPDesk\FCF\Free\Settings\Route\RouteIntegration;
use WPDesk\FCF\Free\Settings\Route\UpdateFormFieldsRoute;
use WPDesk\FCF\Free\Settings\Route\UpdateFormSettingsRoute;

/**
 * Supports management for REST API routes.
 */
class Routes {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new RouteIntegration( new UpdateFormFieldsRoute() ) )->hooks();
		( new RouteIntegration( new UpdateFormSettingsRoute() ) )->hooks();
	}
}
