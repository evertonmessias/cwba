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
 * Class WC_WooMercadoPago_Preference_Basic
 */
class WC_WooMercadoPago_Preference_Custom_Wallet_Button extends WC_WooMercadoPago_Preference_Basic {

	/**
	 * WC_WooMercadoPago_Preference_Custom_Wallet_Button constructor.
	 *
	 * @param $payment
	 * @param $order
	 */
	public function __construct( $payment, $order ) {
		parent::__construct( $payment, $order );
		$this->preference['purpose'] = 'wallet_purchase';
	}

	/**
	 * Overwrite the default method to set Wallet Button Data
	 *
	 * @return string[]
	 */
	public function get_internal_metadata_basic() {
		return array(
			'checkout'      => 'pro',
			'checkout_type' => 'wallet_button',
		);
	}

}
