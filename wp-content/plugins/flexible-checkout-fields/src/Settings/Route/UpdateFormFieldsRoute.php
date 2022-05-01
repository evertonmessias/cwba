<?php

namespace WPDesk\FCF\Free\Settings\Route;

use WPDesk\FCF\Free\Settings\Form\EditFieldsForm;

/**
 * {@inheritdoc}
 */
class UpdateFormFieldsRoute extends RouteAbstract {

	const REST_API_ROUTE = '(?P<form_section>[a-z_]+)/fields';

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
			'form_section' => [
				'description' => 'Section name',
				'required'    => true,
			],
			'form_fields'  => [
				'description' => 'Form fields',
				'required'    => true,
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
			$status = ( new EditFieldsForm() )->save_form_data( $params );
			if ( $status !== true ) {
				throw new \Exception();
			}

			return null;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}
