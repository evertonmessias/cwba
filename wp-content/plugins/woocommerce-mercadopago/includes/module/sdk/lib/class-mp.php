<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['LIB_LOCATION'] = dirname( __FILE__ );

/**
 * Class MP
 */
class MP {

	/**
	 * Client Id
	 *
	 * @var false|mixed
	 */
	private $client_id;

	/**
	 * Client secret
	 *
	 * @var false|mixed
	 */
	private $client_secret;

	/**
	 * LL access token
	 *
	 * @var false|mixed
	 */
	private $ll_access_token;

	/**
	 * Is sandbox?
	 *
	 * @var bool
	 */
	private $sandbox = false;

	/**
	 * Access token by client
	 *
	 * @var string
	 */
	private $access_token_by_client;

	/**
	 * Payment class
	 *
	 * @var WC_WooMercadoPago_Payment_Abstract
	 */
	private $payment_class;

	/**
	 * MP constructor.
	 *
	 * @throws WC_WooMercadoPago_Exception MP Class exception.
	 */
	public function __construct() {
		$includes_path = dirname( __FILE__ );
		require_once $includes_path . '/rest-client/class-meli-rest-client.php';

		$i = func_num_args();
		if ( $i > 2 || $i < 1 ) {
			throw new WC_WooMercadoPago_Exception( 'Invalid arguments. Use CLIENT_ID and CLIENT SECRET, or ACCESS_TOKEN' );
		}

		if ( 1 === $i ) {
			$this->ll_access_token = func_get_arg( 0 );
		}

		if ( 2 === $i ) {
			$this->client_id     = func_get_arg( 0 );
			$this->client_secret = func_get_arg( 1 );
		}
	}

	/**
	 * Set e-mail
	 *
	 * @param string $email E-mail.
	 */
	public function set_email( $email ) {
		MP_Rest_Client::set_email( $email );
		Meli_Rest_Client::set_email( $email );
	}

	/**
	 * Set Locale
	 *
	 * @param string $country_code Country code.
	 */
	public function set_locale( $country_code ) {
		MP_Rest_Client::set_locale( $country_code );
		Meli_Rest_Client::set_locale( $country_code );
	}

	/**
	 * Sandbox is enable?
	 *
	 * @param bool|null $enable Is enable.
	 *
	 * @return bool
	 */
	public function sandbox_mode( $enable = null ) {
		if ( ! is_null( $enable ) ) {
			$this->sandbox = true === $enable;
		}

		return $this->sandbox;
	}

	/**
	 * Get Access Token
	 *
	 * @return mixed|null
	 * @throws WC_WooMercadoPago_Exception Get Access Token Exception.
	 */
	public function get_access_token() {
		if ( isset( $this->ll_access_token ) && ! is_null( $this->ll_access_token ) ) {
			return $this->ll_access_token;
		}

		if ( ! empty( $this->access_token_by_client ) ) {
			return $this->access_token_by_client;
		}

		$app_client_values = array(
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'grant_type'    => 'client_credentials',
		);

		$access_data = MP_Rest_Client::post(
			array(
				'uri'     => '/oauth/token',
				'data'    => $app_client_values,
				'headers' => array(
					'content-type' => 'application/x-www-form-urlencoded',
				),
			)
		);

		if ( 200 !== $access_data['status'] ) {
			return null;
		}

		$response                     = $access_data['response'];
		$this->access_token_by_client = $response['access_token'];

		return $this->access_token_by_client;
	}

	/**
	 * Search Payment V1
	 *
	 * @param string $id Payment Id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Search Payment V1 Exception.
	 */
	public function search_payment_v1( $id, $token = null ) {
		$key = sprintf( '%s%s', __FUNCTION__, $id );

		$cache = $this->get_cache_response( $key );

		if ( ! empty( $cache ) ) {
			$this->debug_mode_log(
				'mercadopago_requests',
				__FUNCTION__,
				__( 'Response from cache', 'woocommerce-mercadopago' )
			);

			return $cache;
		}

		$request = array(
			'uri'     => '/v1/payments/' . $id,
			'headers' => array(
				'Authorization' => 'Bearer ' . ( is_null( $token ) ? $this->get_access_token() : $token ),
			)
		);

		return MP_Rest_Client::get( $request );
	}

	// === CUSTOMER CARDS FUNCTIONS ===

	/**
	 * Get or Create Customer
	 *
	 * @param string $payer_email Payer e-mail.
	 *
	 * @return array|mixed|null
	 * @throws WC_WooMercadoPago_Exception Get or create customer exception.
	 */
	public function get_or_create_customer( $payer_email ) {

		$customer = $this->search_customer( $payer_email );

		if ( 200 === $customer['status'] && $customer['response']['paging']['total'] > 0 ) {
			$customer = $customer['response']['results'][0];
		} else {
			$resp     = $this->create_customer( $payer_email );
			$customer = $resp['response'];
		}

		return $customer;
	}

	/**
	 * Create Customer
	 *
	 * @param string $email E-mail.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Create customer exception.
	 */
	public function create_customer( $email ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers',
			'data'    => array(
				'email' => $email,
			),
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Search customer
	 *
	 * @param string $email E-mail.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Search customer exception.
	 */
	public function search_customer( $email ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers/search',
			'params'  => array(
				'email' => $email,
			),
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Create card in customer
	 *
	 * @param string $customer_id Customer id.
	 * @param string $token Token.
	 * @param string|null $payment_method_id Payment method id.
	 * @param string|null $issuer_id Issuer id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Create card in customer exception.
	 */
	public function create_card_in_customer(
		$customer_id,
		$token,
		$payment_method_id = null,
		$issuer_id = null
	) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers/' . $customer_id . '/cards',
			'data'    => array(
				'token'             => $token,
				'issuer_id'         => $issuer_id,
				'payment_method_id' => $payment_method_id,
			),
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Get all customer cards.
	 *
	 * @param string $customer_id Customer Id.
	 * @param string $token Token.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get all customer cards exception.
	 */
	public function get_all_customer_cards( $customer_id, $token ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers/' . $customer_id . '/cards',
		);

		return MP_Rest_Client::get( $request );
	}

	// === COUPOM AND DISCOUNTS FUNCTIONS ===

	/**
	 * Check discount campaigns
	 *
	 * @param string $transaction_amount Amount.
	 * @param string $payer_email Payer e-mail.
	 * @param string $coupon_code Coupon code.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Check Discount Campaigns Exception.
	 */
	public function check_discount_campaigns( $transaction_amount, $payer_email, $coupon_code ) {
		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/discount_campaigns',
			'params'  => array(
				'transaction_amount' => $transaction_amount,
				'payer_email'        => $payer_email,
				'coupon_code'        => $coupon_code,
			),
		);

		return MP_Rest_Client::get( $request );
	}

	// === CHECKOUT AUXILIARY FUNCTIONS ===

	/**
	 * Get Authorized Payment Id
	 *
	 * @param string $id Authorized Payment Id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get Authorized Payment Exception.
	 */
	public function get_authorized_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/authorized_payments/{$id}',
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Create Preference
	 *
	 * @param array $preference Preference data.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Create Preference Exception.
	 */
	public function create_preference( $preference ) {

		$request = array(
			'uri'     => '/checkout/preferences',
			'headers' => array(
				'user-agent'    => 'platform:desktop,type:woocommerce,so:' . WC_WooMercadoPago_Constants::VERSION,
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'data'    => $preference,
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Update Preference
	 *
	 * @param string $id Preference Id.
	 * @param array $preference Preference data.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Update Preference Exception.
	 */
	public function update_preference( $id, $preference ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/checkout/preferences/{$id}',
			'data'    => $preference,
		);

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Get Preference
	 *
	 * @param string $id Preference id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get Preference.
	 */
	public function get_preference( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/checkout/preferences/{$id}',
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Create Payment
	 *
	 * @param array $preference Preference.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Create Payment.
	 */
	public function create_payment( $preference ) {

		$request = array(
			'uri'     => '/v1/payments',
			'headers' => array(
				'X-Tracking-Id' => 'platform:v1-whitelabel,type:woocommerce,so:' . WC_WooMercadoPago_Constants::VERSION,
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'data'    => $preference,
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Create Preapproval Payment
	 *
	 * @param array $preapproval_payment Preapproval Payment.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Create Preapproval Payment.
	 */
	public function create_preapproval_payment( $preapproval_payment ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval',
			'data'    => $preapproval_payment,
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Get Preapproval Payment
	 *
	 * @param string $id Payment Id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get Preapproval payment exception.
	 */
	public function get_preapproval_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval/' . $id,
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Update Preapproval payment
	 *
	 * @param string $id Payment Id.
	 * @param array $preapproval_payment Pre Approval Payment.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Update preapproval payment exception.
	 */
	public function update_preapproval_payment( $id, $preapproval_payment ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval/' . $id,
			'data'    => $preapproval_payment,
		);

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Cancel preapproval payment
	 *
	 * @param string $id Preapproval Id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Cancel Preapproval payment.
	 */
	public function cancel_preapproval_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval/' . $id,
			'data'    => array(
				'status' => 'cancelled',
			),
		);

		return MP_Rest_Client::put( $request );
	}

	// === REFUND AND CANCELING FLOW FUNCTIONS ===

	/**
	 * Refund payment
	 *
	 * @param string $id Payment id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Refund payment exception.
	 */
	public function refund_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/payments/' . $id . '/refunds',
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Partial refund payment
	 *
	 * @param string $id Payment id.
	 * @param string|float $amount Amount.
	 * @param string $reason Reason.
	 * @param string $external_reference External reference.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Partial refund exception.
	 */
	public function partial_refund_payment( $id, $amount, $reason, $external_reference ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/payments/' . $id . '/refunds',
			'data'    => array(
				'amount'   => $amount,
				'metadata' => array(
					'metadata'           => $reason,
					'external_reference' => $external_reference,
				),
			),
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Cancel payment
	 *
	 * @param string $id Payment id.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Cancel payment exception.
	 */
	public function cancel_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/payments/' . $id,
			'data'    => '{"status":"cancelled"}',
		);

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Get payment method
	 *
	 * @param string $access_token Access token.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get payment method exception.
	 */
	public function get_payment_methods( $access_token ) {
		$key = sprintf( '%s%s', __FUNCTION__, $access_token );

		$cache = $this->get_cache_response( $key );

		if ( ! empty( $cache ) ) {
			$this->debug_mode_log(
				'mercadopago_requests',
				__FUNCTION__,
				__( 'Response from cache', 'woocommerce-mercadopago' )
			);

			return $cache;
		}

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $access_token,
			),
			'uri'     => '/v1/payment_methods',
		);

		$response = MP_Rest_Client::get( $request );

		if ( $response['status'] > 202 ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( 'get_payment_methods' );
			$log->write_log( 'API get_payment_methods error: ', $response['response']['message'] );

			return null;
		}

		asort( $response );

		$this->build_payment_places( $response['response'] );
		$this->set_cache_response( $key, $response );

		return $response;
	}

	/**
	 * Validate if the seller is homologated
	 *
	 * @param string|null $access_token Access token.
	 * @param string|null $public_key Public key.
	 *
	 * @return array|null|false
	 * @throws WC_WooMercadoPago_Exception Get credentials wrapper.
	 */
	public function get_credentials_wrapper( $access_token = null, $public_key = null ) {
		$key = sprintf( '%s%s%s', __FUNCTION__, $access_token, $public_key );

		$cache = $this->get_cache_response( $key );

		if ( ! empty( $cache ) ) {
			$this->debug_mode_log(
				'mercadopago_requests',
				__FUNCTION__,
				__( 'Response from cache', 'woocommerce-mercadopago' )
			);

			return $cache;
		}

		$request = array(
			'uri' => '/plugins-credentials-wrapper/credentials',
		);

		if ( ! empty( $access_token ) && empty( $public_key ) ) {
			$request['headers'] = array( 'Authorization' => 'Bearer ' . $access_token );
		}

		if ( empty( $access_token ) && ! empty( $public_key ) ) {
			$request['params'] = array( 'public_key' => $public_key );
		}

		$response = MP_Rest_Client::get( $request );

		if ( $response['status'] > 202 ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( __FUNCTION__ );
			$log->write_log( 'API GET Credentials Wrapper error:', wp_json_encode( $response ) );

			return false;
		}

		$this->set_cache_response( $key, $response['response'] );

		return $response['response'];
	}

	public function get_me( $access_token ) {
		$key = sprintf( '%s%s', __FUNCTION__, $access_token );

		$cache = $this->get_cache_response( $key );

		if ( ! empty( $cache ) ) {
			$this->debug_mode_log(
				'mercadopago_requests',
				__FUNCTION__,
				__( 'Response from cache', 'woocommerce-mercadopago' )
			);

			return $cache;
		}

		$request = array(
			'uri' => '/users/me',
			'headers' => array( 'Authorization' => 'Bearer ' . $access_token )
		);

		$response = MP_Rest_Client::get( $request );

		if ( $response['status'] > 202 ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( __FUNCTION__ );
			$log->write_log( 'API GET users me error:', wp_json_encode( $response ) );

			return false;
		}

		$this->set_cache_response( $key, $response['response'] );

		return $response['response'];
	}

	// === GENERIC RESOURCE CALL METHODS ===

	/**
	 * Get call
	 *
	 * @param string|array $request Request.
	 * @param array $headers Headers.
	 * @param bool $authenticate Is authenticate.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get exception.
	 */
	public function get( $request, $headers = array(), $authenticate = true ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers'      => $headers,
				'uri'          => $request,
				'authenticate' => $authenticate,
			);
		}

		if ( ! isset( $request['authenticate'] ) || false !== $request['authenticate'] ) {
			$access_token = $this->get_access_token();
			if ( ! empty( $access_token ) ) {
				$request['headers'] = array( 'Authorization' => 'Bearer ' . $access_token );
			}
		}

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Post call
	 *
	 * @param array|string $request Request.
	 * @param null $data Request data.
	 * @param null $params Request params.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Post exception.
	 */
	public function post( $request, $data = null, $params = null ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers' => array( 'Authorization' => 'Bearer ' . $this->get_access_token() ),
				'uri'     => $request,
				'data'    => $data,
				'params'  => $params,
			);
		}

		$request['params'] = isset( $request['params'] ) && is_array( $request['params'] ) ?
			$request['params'] :
			array();

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Put call
	 *
	 * @param array|string $request Request.
	 * @param null $data Request data.
	 * @param null $params Request params.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Put exception.
	 */
	public function put( $request, $data = null, $params = null ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers' => array( 'Authorization' => 'Bearer ' . $this->get_access_token() ),
				'uri'     => $request,
				'data'    => $data,
				'params'  => $params,
			);
		}

		$request['params'] = isset( $request['params'] ) && is_array( $request['params'] ) ?
			$request['params'] :
			array();

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Delete call
	 *
	 * @param array|string $request Request.
	 * @param null|array $params Params.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Delete exception.
	 */
	public function delete( $request, $params = null ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers' => array( 'Authorization' => 'Bearer ' . $this->get_access_token() ),
				'uri'     => $request,
				'params'  => $params,
			);
		}

		$request['params'] = isset( $request['params'] ) && is_array( $request['params'] ) ?
			$request['params'] :
			array();

		return MP_Rest_Client::delete( $request );
	}

	/**
	 * Set payment class
	 *
	 * @param null|WC_WooMercadoPago_Payment_Abstract $payment Payment class.
	 */
	public function set_payment_class( $payment = null ) {
		if ( ! is_null( $payment ) ) {
			$this->payment_class = get_class( $payment );
		}
	}

	/**
	 * Get payment class
	 *
	 * @return WC_WooMercadoPago_Payment_Abstract
	 */
	public function get_payment_class() {
		return $this->payment_class;
	}


	/**
	 * Get response from cache
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	protected function get_cache_response( $key ) {
		$key = sha1( $key );

		return get_transient( $key );
	}

	/**
	 * Save a response to cache
	 *
	 * @param $key
	 * @param $value
	 * @param int $ttl
	 */
	protected function set_cache_response( $key, $value, $ttl = MINUTE_IN_SECONDS ) {
		$key = sha1( $key );

		set_transient( $key, $value, $ttl );
	}

	/**
	 * Set log when WordPress in Debug Mode
	 *
	 * @param $log_id
	 * @param $function
	 * @param $message
	 */
	protected function debug_mode_log( $log_id, $function, $message ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( $log_id );
			$log->write_log( $function, $message );
		}
	}

	/**
	 * Buil array payment places
	 *
	 * @param $lpayment_id
	 */
	private function build_payment_places( &$api_response ) {

		$payment_places =
			[
				'paycash' => [
					[
						'payment_option_id' => '7eleven',
						'name'              => '7 Eleven',
						'status'            => 'active',
						'thumbnail'         => 'https://http2.mlstatic.com/storage/logos-api-admin/417ddb90-34ab-11e9-b8b8-15cad73057aa-s.png'
					],
					[
						'payment_option_id' => 'circlek',
						'name'              => 'Circle K',
						'status'            => 'active',
						'thumbnail'         => 'https://http2.mlstatic.com/storage/logos-api-admin/6f952c90-34ab-11e9-8357-f13e9b392369-s.png'
					],
					[
						'payment_option_id' => 'soriana',
						'name'              => 'Soriana',
						'status'            => 'active',
						'thumbnail'         => 'https://http2.mlstatic.com/storage/logos-api-admin/dac0bf10-01eb-11ec-ad92-052532916206-s.png'
					],
					[
						'payment_option_id' => 'extra',
						'name'              => 'Extra',
						'status'            => 'active',
						'thumbnail'         => 'https://http2.mlstatic.com/storage/logos-api-admin/9c8f26b0-34ab-11e9-b8b8-15cad73057aa-s.png'
					],
					[
						'payment_option_id' => 'calimax',
						'name'              => 'Calimax',
						'status'            => 'active',
						'thumbnail'         => 'https://http2.mlstatic.com/storage/logos-api-admin/52efa730-01ec-11ec-ba6b-c5f27048193b-s.png'
					],
				],
			];

		foreach ( $api_response as $k => $method ) {
			if ( isset( $payment_places[ $method['id'] ] ) ) {
				$api_response[ $k ]['payment_places'] = $payment_places[ $method['id'] ];
			}
		}

	}

}
