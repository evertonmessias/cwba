<?php

class WC_WooMercadoPago_Options {

	const CREDENTIALS_PUBLIC_KEY_PROD       = '_mp_public_key_prod';
	const CREDENTIALS_PUBLIC_KEY_TEST       = '_mp_public_key_test';
	const CREDENTIALS_ACCESS_TOKEN_PROD     = '_mp_access_token_prod';
	const CREDENTIALS_ACCESS_TOKEN_TEST     = '_mp_access_token_test';
	const CHECKOUT_COUNTRY                  = 'checkout_country';
	const STORE_ID                          = '_mp_store_identificator';
	const STORE_NAME                        = 'mp_statement_descriptor';
	const STORE_CATEGORY                    = '_mp_category_id';
	const INTEGRATOR_ID                     = '_mp_integrator_id';
	const DEBUG_MODE                        = '_mp_debug_mode';
	const CUSTOM_DOMAIN                     = '_mp_custom_domain';
	const CHECKBOX_CHECKOUT_TEST_MODE       = 'checkbox_checkout_test_mode';
	const CHECKBOX_CHECKOUT_PRODUCTION_MODE = 'checkbox_checkout_production_mode';
	const WOOCOMMERCE_COUNTRY               = 'woocommerce_default_country';
	const HOMOLOG_VALIDATE                  = 'homolog_validate';
	const APPLICATION_ID                    = 'mp_application_id';
	const SITE_ID                           = '_site_id_v1';
	const CLIENT_ID                         = '_mp_client_id';




	private $credentials_public_key_prod;
	private $credentials_public_key_test;
	private $credentials_access_token_prod;
	private $credentials_access_token_test;
	private $checkout_country;
	private $store_id;
	private $store_name;
	private $store_category;
	private $integrator_id;
	private $debug_mode;
	private $custom_domain;
	private $checkbox_checkout_test_mode;
	private $checkbox_checkout_production_mode;
	private $woocommerce_country;
	private $homolog_validate;
	private $application_id;
	private $site_id;
	private $client_id;


	public static $instance;


	public function __construct() {
		$this->credentials_public_key_prod       = get_option( self::CREDENTIALS_PUBLIC_KEY_PROD );
		$this->credentials_public_key_test       = get_option( self::CREDENTIALS_PUBLIC_KEY_TEST );
		$this->credentials_access_token_prod     = get_option( self::CREDENTIALS_ACCESS_TOKEN_PROD );
		$this->credentials_access_token_test     = get_option( self::CREDENTIALS_ACCESS_TOKEN_TEST );
		$this->checkout_country                  = get_option( self::CHECKOUT_COUNTRY);
		$this->store_id                          = get_option( self::STORE_ID );
		$this->store_name                        = get_option( self::STORE_NAME);
		$this->store_category                    = get_option( self::STORE_CATEGORY);
		$this->integrator_id                     = get_option( self::INTEGRATOR_ID );
		$this->debug_mode                        = get_option( self::DEBUG_MODE );
		$this->custom_domain                     = get_option( self::CUSTOM_DOMAIN );
		$this->checkbox_checkout_test_mode       = get_option( self::CHECKBOX_CHECKOUT_TEST_MODE );
		$this->checkbox_checkout_production_mode = get_option( self::CHECKBOX_CHECKOUT_PRODUCTION_MODE );
		$this->woocommerce_country               = get_option( self::WOOCOMMERCE_COUNTRY );
		$this->homolog_validate                  = get_option( self::HOMOLOG_VALIDATE );
		$this->application_id                    = get_option( self::APPLICATION_ID );
		$this->site_id                           = get_option( self::SITE_ID );
		$this->client_id                         = get_option( self::CLIENT_ID );
	}

	/**
	 *
	 * Init Options
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get Access token and Public Key
	 *
	 * @return mixed|array
	 */
	public function get_access_token_and_public_key() {

		return array(
			'credentials_public_key_prod'   => $this->credentials_public_key_prod,
			'credentials_public_key_test'   => $this->credentials_public_key_test,
			'credentials_access_token_prod' => $this->credentials_access_token_prod,
			'credentials_access_token_test' => $this->credentials_access_token_test,
		);

	}

	/**
	 * Get access token prod
	 */
	public function get_access_token_prod() {
		$access_token_prod = $this->credentials_access_token_prod;

		return $access_token_prod;
	}

	/**
	 * Get access token test
	 */
	public function get_access_token_test() {
		$access_token_test = $this->credentials_access_token_test;

		return $access_token_test;
	}

	/**
	 * Get public key prod
	 */
	public function get_public_key_prod() {
		$public_key_prod = $this->credentials_public_key_prod;

		return $public_key_prod;
	}

	/**
	 * Get public key test
	 */
	public function get_public_key_test() {
		$public_key_test = $this->credentials_public_key_test;

		return $public_key_test;
	}

	/**
	 *  Get option checkout country
	 */
	public function get_checkout_country() {
		$checkout_country = $this->checkout_country;

		return strtolower($checkout_country);
	}

	/**
	 *  Get option Store Identificator
	 */
	public function get_store_id() {
		$store_id = $this->store_id;

		return $store_id;
	}

	/**
	 *  Get option Store Name
	 */
	public function get_store_name_on_invoice() {
		$store_name = $this->store_name;

		return $store_name;
	}

	/**
	 *  Get option Store Category
	 */
	public function get_store_category() {
		$category_store = $this->store_category;

		return $category_store;
	}

	/**
	 *  Get option Integrator id
	 */
	public function get_integrator_id() {
		$integrator_id = $this->integrator_id;

		return $integrator_id;
	}

	/**
	 *  Get option Debug Mode
	 */
	public function get_debug_mode() {
		$debug_mode = $this->debug_mode;

		return $debug_mode;
	}

	/**
	 *  Get option Custom Domain
	 */
	public function get_custom_domain() {
		$custom_domain = $this->custom_domain;

		return $custom_domain;
	}

	/**
	 *  Get option Checkbox Test Mode
	 */
	public function get_checkbox_checkout_test_mode() {
		$checkbox_checkout_test_mode = $this->checkbox_checkout_test_mode;

		return $checkbox_checkout_test_mode;
	}

	/**
	 *  Get option Checkbox Production Mode
	 */
	public function get_checkbox_checkout_production_mode() {
		$checkbox_checkout_production_mode = $this->checkbox_checkout_production_mode;

		return $checkbox_checkout_production_mode;
	}

	/**
	 *  Get option woocommerce country
	 */
	public function get_woocommerce_country() {
		$woocommerce_country = $this->woocommerce_country;

		return $woocommerce_country;
	}

	/**
	 *  Get option homolog validate
	 */
	public function get_homolog_validate() {
		$homolog_validate = $this->homolog_validate;

		return $homolog_validate;
	}

	/**
	 *  Get option application id
	 */
	public function get_application_id() {
		$application_id = $this->application_id;

		return $application_id;
	}

	/**
	 *  Get option site id
	 */
	public function get_site_id() {
		$site_id = $this->site_id;

		return strtolower($site_id);
	}

	/**
	 *  Get option client id
	 */
	public function get_client_id() {
		$client_id = $this->client_id;

		return $client_id;
	}
}
