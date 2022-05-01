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

/**
 * Class WC_WooMercadoPago_Helpers_CurrencyConverter
 */
class WC_WooMercadoPago_Helpers_CurrencyConverter {

	const CONFIG_KEY    = 'currency_conversion';
	const DEFAULT_RATIO = 1;

	/**
	 *
	 * Instance variable
	 *
	 * @var WC_WooMercadoPago_Helpers_CurrencyConverter
	 */
	private static $instance;

	/**
	 *
	 * Message description
	 *
	 * @var string $msg_description
	 */
	private $msg_description;

	/**
	 *
	 * Ratios array
	 *
	 * @var array
	 */
	private $ratios = array();

	/**
	 *
	 * Cache array
	 *
	 * @var array
	 */
	private $cache = array();

	/**
	 *
	 * Currency cache
	 *
	 * @var array
	 */
	private $currency_ache = array();

	/**
	 *
	 * Supported Currencies
	 *
	 * @var undefined
	 */
	private $supported_currencies;

	/**
	 *
	 * Is Showing Alert
	 *
	 * @var bool
	 */
	private $is_showing_alert = false;

	/**
	 *
	 * Log
	 *
	 * @var WC_WooMercadoPago_Log
	 * */
	private $log;

	/**
	 * Private constructor to make class singleton
	 */
	private function __construct() {
		$this->msg_description = __( 'Activate this option so that the value of the currency set in WooCommerce is compatible with the value of the currency you use in Mercado Pago.', 'woocommerce-mercadopago' );
		$this->log             = new WC_WooMercadoPago_Log();

		return $this;
	}

	/**
	 *
	 * Load class
	 *
	 * @return static
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 *
	 * Init function
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return $this
	 * @throws Exception Return e.
	 */
	private function init( WC_WooMercadoPago_Payment_Abstract $method ) {
		if ( ! isset( $this->ratios[ $method->id ] ) ) {

			try {
				if ( ! $this->is_enabled( $method ) ) {
					$this->set_ratio( $method->id );

					return $this;
				}

				$account_currency = $this->get_account_currency( $method );
				$local_currency   = get_woocommerce_currency();

				if ( ! $account_currency || $account_currency === $local_currency ) {
					$this->set_ratio( $method->id );

					return $this;
				}

				$this->set_ratio( $method->id, $this->load_ratio( $local_currency, $account_currency, $method ) );
			} catch ( Exception $e ) {
				$this->set_ratio( $method->id );
				throw $e;
			}
		}

		return $this;
	}

	/**
	 *
	 * Get Account Currency
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return mixed|null
	 */
	private function get_account_currency( WC_WooMercadoPago_Payment_Abstract $method ) {
		$key = $method->id;

		if ( isset( $this->currency_ache[ $key ] ) ) {
			return $this->currency_ache[ $key ];
		}

		$site_id = $this->get_site_id( $this->get_access_token( $method ) );

		if ( ! $site_id ) {
			return null;
		}

		$configs = $this->get_country_configs();

		if ( ! isset( $configs[ $site_id ] ) || ! isset( $configs[ $site_id ]['currency'] ) ) {
			return null;
		}

		return isset( $configs[ $site_id ] ) ? $configs[ $site_id ]['currency'] : null;
	}

	/**
	 *
	 * Get Country Configs
	 *
	 * @return array
	 */
	private function get_country_configs() {
		try {
			$config_instance = new WC_WooMercadoPago_Configs();

			return $config_instance->get_country_configs();
		} catch ( Exception $e ) {
			return array();
		}
	}

	/**
	 *
	 * Get Access Token
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return mixed
	 */
	private function get_access_token( WC_WooMercadoPago_Payment_Abstract $method ) {
		$type = $method->get_option( 'checkbox_checkout_test_mode' ) === 'yes'
			? '_mp_access_token_test'
			: '_mp_access_token_prod';

		return $method->get_option( $type );
	}

	/**
	 *
	 * Is Enabled
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return mixed
	 */
	public function is_enabled( WC_WooMercadoPago_Payment_Abstract $method ) {
		return 'yes' === $method->get_option_mp( self::CONFIG_KEY, 'no' );
	}

	/**
	 *
	 * Set Ratio
	 *
	 * @param mixed $method_id method id.
	 * @param int $value value.
	 */
	private function set_ratio( $method_id, $value = self::DEFAULT_RATIO ) {
		$this->ratios[ $method_id ] = $value;
	}

	/**
	 *
	 * Get Ratio
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return int|mixed
	 */
	private function get_ratio( WC_WooMercadoPago_Payment_Abstract $method ) {
		$this->init( $method );

		return isset( $this->ratios[ $method->id ] )
			? $this->ratios[ $method->id ]
			: self::DEFAULT_RATIO;
	}

	/**
	 *
	 * Load Ratio
	 *
	 * @param string $from_currency from Currency.
	 * @param string $to_currency to Currency.
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return int
	 * @throws Exception Return e.
	 */
	public function load_ratio( $from_currency, $to_currency, WC_WooMercadoPago_Payment_Abstract $method = null ) {
		$cache_key = $from_currency . '--' . $to_currency;

		if ( isset( $this->cache[ $cache_key ] ) ) {
			return $this->cache[ $cache_key ];
		}

		$ratio = self::DEFAULT_RATIO;

		if ( $from_currency === $to_currency ) {
			$this->cache[ $cache_key ] = $ratio;

			return $ratio;
		}

		try {
			$result = Meli_Rest_Client::get(
				array(
					'uri'     => sprintf( '/currency_conversions/search?from=%s&to=%s', $from_currency, $to_currency ),
					'headers' => array(
						'Authorization' => 'Bearer ' . $this->get_access_token( $method ),
					),
				)
			);

			if ( 200 !== $result['status'] ) {
				$this->log->write_log( __FUNCTION__, 'Mercado pago gave error to get currency value, payment creation failed with error: ' . wp_json_encode( $result ) );
				$ratio = self::DEFAULT_RATIO;
				throw new Exception( 'Status: ' . $result['status'] . ' Message: ' . $result['response']['message'] );
			}

			if ( isset( $result['response'], $result['response']['ratio'] ) ) {
				$ratio = $result['response']['ratio'] > 0 ? $result['response']['ratio'] : self::DEFAULT_RATIO;
			}
		} catch ( Exception $e ) {
			$this->log->write_log(
				"WC_WooMercadoPago_Helpers_CurrencyConverter::load_ratio('$from_currency', '$to_currency')",
				$e->__toString()
			);

			throw $e;
		}

		$this->cache[ $cache_key ] = $ratio;

		return $ratio;
	}

	/**
	 *
	 * Get SiteId
	 *
	 * @param string $access_token Access token.
	 *
	 * @return string | null
	 */
	private function get_site_id( $access_token ) {
		try {
			$site_id = strtolower(get_option( '_site_id_v1', false ));

			if ( $site_id ) {
				return $site_id;
			}

			$mp      = new MP( $access_token );
			$result  = $mp->get( '/users/me', array( 'Authorization' => 'Bearer ' . $access_token ) );
			$site_id = isset( $result['response'], $result['response']['site_id'] ) ? $result['response']['site_id'] : null;

			update_option( '_site_id_v1', $site_id );

			return $site_id;
		} catch ( Exception $e ) {
			return null;
		}
	}

	/**
	 *
	 * Ratio
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return float
	 */
	public function ratio( WC_WooMercadoPago_Payment_Abstract $method ) {
		$this->init( $method );

		return $this->get_ratio( $method );
	}

	/**
	 *
	 * Get Description
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return string|void
	 */
	public function get_description( WC_WooMercadoPago_Payment_Abstract $method ) {
		return $this->msg_description;
	}

	/**
	 * Check if currency is supported in mercado pago API
	 *
	 * @param string $currency currency.
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return bool
	 */
	private function is_currency_supported( $currency, WC_WooMercadoPago_Payment_Abstract $method ) {
		foreach ( $this->get_supported_currencies( $method ) as $country ) {
			if ( $country['id'] === $currency ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get supported currencies from mercado pago API
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 *
	 * @return array|bool
	 */
	public function get_supported_currencies( WC_WooMercadoPago_Payment_Abstract $method ) {
		if ( is_null( $this->supported_currencies ) ) {
			try {

				$request = array(
					'uri'     => '/currencies',
					'headers' => array(
						'Authorization' => 'Bearer ' . $this->get_access_token( $method ),
					),
				);

				$result = Meli_Rest_Client::get( $request );

				if ( ! isset( $result['response'] ) ) {
					return false;
				}

				$this->supported_currencies = $result['response'];
			} catch ( Exception $e ) {
				$this->supported_currencies = array();
			}
		}

		return $this->supported_currencies;
	}

	/**
	 *
	 * Schedule Notice
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method methos.
	 * @param array $old_data old data.
	 * @param array $new_data new data.
	 */
	public function schedule_notice( WC_WooMercadoPago_Payment_Abstract $method, $old_data, $new_data ) {
		if ( ! isset( $old_data[ self::CONFIG_KEY ] ) || ! isset( $new_data[ self::CONFIG_KEY ] ) ) {
			return;
		}

		if ( $old_data[ self::CONFIG_KEY ] !== $new_data[ self::CONFIG_KEY ] ) {
			$_SESSION[ self::CONFIG_KEY ]['notice'] = array(
				'type'   => 'yes' === $new_data[ self::CONFIG_KEY ] ? 'enabled' : 'disabled',
				'method' => $method,
			);
		}
	}

	/**
	 *
	 * Notices
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 */
	public function notices( WC_WooMercadoPago_Payment_Abstract $method ) {
		$show           = isset( $_SESSION[ self::CONFIG_KEY ] ) ? $_SESSION[ self::CONFIG_KEY ] : array();
		$local_currency = get_woocommerce_currency();

		$account_currency = $this->get_account_currency( $method );

		if ( $local_currency === $account_currency || empty( $account_currency ) ) {
			return;
		}

		if ( isset( $show['notice'] ) ) {
			unset( $_SESSION[ self::CONFIG_KEY ]['notice'] );
			if ( 'enabled' === $show['notice']['type'] ) {
				$this->notice_enabled( $method );
			} elseif ( 'disabled' === $show['notice']['type'] ) {
				$this->notice_disabled( $method );
			}
		}

		if ( ! $this->is_enabled( $method ) && ! $this->is_showing_alert && $method->is_currency_convertable() ) {
			$this->notice_warning( $method );
		}
	}

	/**
	 *
	 * Notice Enabled
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 */
	public function notice_enabled( WC_WooMercadoPago_Payment_Abstract $method ) {
		$local_currency = get_woocommerce_currency();
		$currency       = $this->get_account_currency( $method );
		$type           = 'notice-error';
		$message        = sprintf(
		/* translators: 1: local currency 2: currency */
			__( 'Now we convert your currency from %1$s to %2$s.', 'woocommerce-mercadopago' ),
			$local_currency,
			$currency
		);

		WC_WooMercadoPago_Notices::get_alert_frame( $message, $type );
	}

	/**
	 *
	 * Notice Disabled
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 */
	public function notice_disabled( WC_WooMercadoPago_Payment_Abstract $method ) {
		$local_currency = get_woocommerce_currency();
		$currency       = $this->get_account_currency( $method );
		$type           = 'notice-error';
		$message        = sprintf(
		/* translators: 1: local currency 2: currency */
			__( 'We no longer convert your currency from %1$s to %2$s.', 'woocommerce-mercadopago' ),
			$local_currency,
			$currency
		);

		WC_WooMercadoPago_Notices::get_alert_frame( $message, $type );
	}

	/**
	 *
	 * Notice Warning
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method method.
	 */
	public function notice_warning( WC_WooMercadoPago_Payment_Abstract $method ) {
		global $current_section;

		if ( in_array( $current_section, array( $method->id, sanitize_title( get_class( $method ) ) ), true ) ) {
			$this->is_showing_alert = true;

			$type    = 'notice-error';
			$message = __( '<b>Attention:</b> The currency settings you have in WooCommerce are not compatible with the currency you use in your Mercado Pago account. Please activate the currency conversion.', 'woocommerce-mercadopago' );

			WC_WooMercadoPago_Notices::get_alert_frame( $message, $type );
		}
	}

	/**
	 *
	 * Translate
	 *
	 * @param string $str str.
	 * @param mixed ...$values value.
	 *
	 * @return string|void
	 */
	private function __( $str, ...$values ) {
		$translated = $str;

		if ( ! empty( $values ) ) {
			$translated = vsprintf( $translated, $values );
		}

		return $translated;
	}
}
