<?php

namespace WPDesk\FCF\Free\Settings\Route;

/**
 * {@inheritdoc}
 */
abstract class RouteAbstract implements RouteInterface {

	/**
	 * {@inheritdoc}
	 */
	public function get_route_methods(): array {
		return [ 'POST' ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_route_params(): array {
		return [
			'form_values'     => [
				'description' => 'Form values',
				'required'    => true,
				'default'     => [],
			],
			'form_field_name' => [
				'description' => 'Key of field',
				'required'    => true,
				'default'     => '',
			],
			'form_section'    => [
				'description' => 'Section name',
				'required'    => true,
				'default'     => '',
			],
			'form_fields'     => [
				'description' => 'Form fields',
				'required'    => true,
				'default'     => [],
			],
		];
	}
}
