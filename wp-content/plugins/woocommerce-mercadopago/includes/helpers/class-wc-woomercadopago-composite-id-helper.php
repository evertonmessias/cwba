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
 * Class WC_WooMercadoPago_Composite_Id_Helper
 */
class WC_WooMercadoPago_Composite_Id_Helper {

	const SEPARATOR = '|';

	public function generateIdFromPlace( $paymentMethodId, $paymentPlaceId ) {
		return $paymentMethodId . self::SEPARATOR . $paymentPlaceId;
	}

	private function parse( $compositeId ) {

		$exploded = explode(self::SEPARATOR, $compositeId);

		return [
			'payment_method_id' => $exploded[0],
			'payment_place_id' => isset($exploded[1]) ? $exploded[1] : null,
		];
	}

	public function getPaymentMethodId( $compositeId ) {
		return $this->parse($compositeId)['payment_method_id'];
	}

	public function getPaymentPlaceId( $compositeId ) {
		return $this->parse($compositeId)['payment_place_id'];
	}
}
