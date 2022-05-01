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
 * Class MPRestClient
 */
class MP_Rest_Client extends Mp_Rest_Client_Abstract {

	/**
	 * Get method
	 *
	 * @param array $request Request.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get exception.
	 */
	public static function get( $request ) {
		$request['method'] = 'GET';
		return self::exec_abs( $request, WC_WooMercadoPago_Constants::API_MP_BASE_URL );
	}

	/**
	 * Post method
	 *
	 * @param array $request Request.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Post exception.
	 */
	public static function post( $request ) {
		$request['method'] = 'POST';
		return self::exec_abs( $request, WC_WooMercadoPago_Constants::API_MP_BASE_URL );
	}

	/**
	 * Put method
	 *
	 * @param array $request Request.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Put exception.
	 */
	public static function put( $request ) {
		$request['method'] = 'PUT';
		return self::exec_abs( $request, WC_WooMercadoPago_Constants::API_MP_BASE_URL );
	}

	/**
	 * Delete method
	 *
	 * @param array $request Request.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Delete exception.
	 */
	public static function delete( $request ) {
		$request['method'] = 'DELETE';
		return self::exec_abs( $request, WC_WooMercadoPago_Constants::API_MP_BASE_URL );
	}

}
