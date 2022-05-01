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
 * Class Mp_Rest_Client_Abstract
 *
 * @todo Refactor this class to use wp_remote_get()
 */
class Mp_Rest_Client_Abstract {

	/**
	 * E-mail admin
	 *
	 * @var string
	 */
	public static $email_admin = '';

	/**
	 * Site locale
	 *
	 * @var string
	 */
	public static $site_locale = '';

	/**
	 * Check loop
	 *
	 * @var int
	 */
	public static $check_loop = 0;

	/**
	 * Exec ABS
	 *
	 * @param array $request Request.
	 * @param string $url URL.
	 *
	 * @return array|null
	 */
	public static function exec_abs( $request, $url ) {
		try {
			$connect = self::build_request( $request, $url );

			return self::execute( $request, $connect );
		} catch ( Exception $e ) {
			return null;
		}
	}

	/**
	 * Build request
	 *
	 * @param array $request Request data.
	 * @param string $url URL.
	 *
	 * @return CurlHandle|false|resource
	 * @throws WC_WooMercadoPago_Exception Build request exception.
	 */
	public static function build_request( $request, $url ) {
		if ( ! extension_loaded( 'curl' ) ) {
			throw new WC_WooMercadoPago_Exception( 'cURL extension not found. You need to enable cURL in your php.ini or another configuration you have.' );
		}

		if ( ! isset( $request['method'] ) ) {
			throw new WC_WooMercadoPago_Exception( 'No HTTP METHOD specified' );
		}

		if ( ! isset( $request['uri'] ) ) {
			throw new WC_WooMercadoPago_Exception( 'No URI specified' );
		}

		$headers = array( 'accept: application/json' );
		if ( 'POST' === $request['method'] ) {
			$headers[] = 'x-product-id:' . ( WC_WooMercadoPago_Module::is_mobile() ? WC_WooMercadoPago_Constants::PRODUCT_ID_MOBILE : WC_WooMercadoPago_Constants::PRODUCT_ID_DESKTOP );
			$headers[] = 'x-platform-id:' . WC_WooMercadoPago_Constants::PLATAFORM_ID;
			$headers[] = 'x-integrator-id:' . get_option( '_mp_integrator_id', null );
		}

		$json_content         = true;
		$form_content         = false;
		$default_content_type = true;

		if ( isset( $request['headers'] ) && is_array( $request['headers'] ) ) {
			foreach ( $request['headers'] as $h => $v ) {
				if ( 'content-type' === $h ) {
					$default_content_type = false;
					$json_content         = 'application/json' === $v;
					$form_content         = 'application/x-www-form-urlencoded' === $v;
				}
				$headers[] = $h . ': ' . $v;
			}
		}
		if ( $default_content_type ) {
			$headers[] = 'content-type: application/json';
		}

		//@codingStandardsIgnoreStart
		$connect = curl_init();
		curl_setopt( $connect, CURLOPT_USERAGENT, 'platform:v1-whitelabel,type:woocommerce,so:' . WC_WooMercadoPago_Constants::VERSION );
		curl_setopt( $connect, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $connect, CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $connect, CURLOPT_CAINFO, $GLOBALS['LIB_LOCATION'] . '/cacert.pem' );
		curl_setopt( $connect, CURLOPT_CUSTOMREQUEST, $request['method'] );
		curl_setopt( $connect, CURLOPT_HTTPHEADER, $headers );
		//@codingStandardsIgnoreEnd

		if ( isset( $request['params'] ) && is_array( $request['params'] ) ) {
			if ( count( $request['params'] ) > 0 ) {
				$request['uri'] .= ( strpos( $request['uri'], '?' ) === false ) ? '?' : '&';
				$request['uri'] .= self::build_query( $request['params'] );
			}
		}
		// @codingStandardsIgnoreLine
		curl_setopt( $connect, CURLOPT_URL, $url . $request['uri'] );

		if ( isset( $request['data'] ) ) {
			if ( $json_content ) {
				if ( is_string( $request['data'] ) ) {
					json_decode( $request['data'], true );
				} else {
					$request['data'] = wp_json_encode( $request['data'] );
				}
				if ( function_exists( 'json_last_error' ) ) {
					$json_error = json_last_error();
					if ( JSON_ERROR_NONE !== $json_error ) {
						throw new WC_WooMercadoPago_Exception( "JSON Error [{$json_error}] - Data: " . $request['data'] );
					}
				}
			} elseif ( $form_content ) {
				$request['data'] = self::build_query( $request['data'] );
			}
			// @codingStandardsIgnoreLine
			curl_setopt( $connect, CURLOPT_POSTFIELDS, $request['data'] );
		}

		return $connect;
	}

	/**
	 * Execute curl
	 *
	 * @param array $request Request data.
	 * @param CurlHandle $connect Curl Handle Connection.
	 *
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Execute call exception.
	 */
	public static function execute( $request, $connect ) {
		$response = null;
		// @codingStandardsIgnoreLine
		$api_result = curl_exec( $connect );
		// @codingStandardsIgnoreLine
		if ( curl_errno( $connect ) ) {
			// @codingStandardsIgnoreLine
			throw new WC_WooMercadoPago_Exception( curl_error( $connect ) );
		}

		$info          = curl_getinfo( $connect ); //phpcs:ignore
		$api_http_code = $info['http_code']; //phpcs:ignore

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( 'mercadopago_requests' );
			$log->write_log(
				'Execute cURL',
				sprintf(
					/* translators: 1: total_time currency 2: url */
					__('Took %1$s seconds to transfer a request to %2$s', 'woocommerce-mercadopago'),
					$info['total_time'],
					$info['url']
				)
			);
		}

		if ( null !== $api_http_code && null !== $api_result ) {
			$response = array(
				'status'   => $api_http_code,
				'response' => json_decode( $api_result, true ),
			);
		}

		curl_close( $connect ); //phpcs:ignore

		return $response;
	}

	/**
	 * Build query
	 *
	 * @param array $params Params.
	 *
	 * @return string
	 */
	public static function build_query( $params ) {
		if ( function_exists( 'http_build_query' ) ) {
			return http_build_query( $params, '', '&' );
		} else {
			foreach ( $params as $name => $value ) {
				$elements[] = "{$name}=" . rawurldecode( $value );
			}

			return implode( '&', $elements );
		}
	}

	/**
	 * Set e-mail
	 *
	 * @param string $email E-mail.
	 */
	public static function set_email( $email ) {
		self::$email_admin = $email;
	}

	/**
	 * Set Country code
	 *
	 * @param string $country_code Country code.
	 */
	public static function set_locale( $country_code ) {
		self::$site_locale = $country_code;
	}
}
