<?php

namespace WPDesk\FCF\Free\Settings\Route;

use WPDesk\FCF\Free\Settings\Form\SettingsPageForm;

/**
 * {@inheritdoc}
 */
class UpdateFormSettingsRoute extends RouteAbstract {

	const REST_API_ROUTE = 'settings';

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_route(): string {
		return self::REST_API_ROUTE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_route_params(): array {
		return [
			'form_fields' => [
				'description' => 'Form fields',
				'required'    => true,
				'default'     => [],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws \Exception
	 */
	public function get_endpoint_response( array $params ) {
		try {
			$status = ( new SettingsPageForm() )->save_form_data( $params );
			if ( $status !== true ) {
				throw new \Exception();
			}

			return null;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}
