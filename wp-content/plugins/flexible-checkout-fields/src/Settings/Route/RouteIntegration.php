<?php

namespace WPDesk\FCF\Free\Settings\Route;

/**
 * Initializes integration for REST API route.
 */
class RouteIntegration {

	const REST_API_NAMESPACE = 'flexible-checkout-fields/v1';

	/**
	 * Class object for value.
	 *
	 * @var RouteInterface
	 */
	private $value_object;

	/**
	 * Class constructor.
	 *
	 * @param RouteInterface $value_object Class object of field type.
	 */
	public function __construct( RouteInterface $value_object ) {
		$this->value_object = $value_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'rest_api_init', [ $this, 'register_endpoint' ] );
	}

	/**
	 * Registers REST API route.
	 *
	 * @internal
	 */
	public function register_endpoint() {
		register_rest_route(
			self::REST_API_NAMESPACE,
			$this->value_object->get_endpoint_route(),
			[
				'methods'             => $this->value_object->get_route_methods(),
				'args'                => $this->value_object->get_route_params(),
				'callback'            => [ $this, 'get_endpoint_response' ],
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			],
			true
		);
	}

	/**
	 * Registers REST API route.
	 *
	 * @param \WP_REST_Request $request .
	 *
	 * @return \WP_REST_Response|\WP_Error .
	 * @internal
	 */
	public function get_endpoint_response( \WP_REST_Request $request ) {
		$params = $request->get_params();

		try {
			$response = $this->value_object->get_endpoint_response( $params );

			return new \WP_REST_Response(
				$response,
				200
			);
		} catch ( \Exception $e ) {
			$message = $e->getMessage()
				?: __( 'An unknown error occurred while processing the request.', 'flexible-checkout-fields' );

			return new \WP_Error(
				'fcf_error',
				$message,
				[
					'status' => 400,
				]
			);
		}
	}
}
