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
 * Class WC_WooMercadoPago_Preference_Ticket
 */
class WC_WooMercadoPago_Preference_Ticket extends WC_WooMercadoPago_Preference_Abstract {

	/**
	 * WC_WooMercadoPago_PreferenceTicket constructor.
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $payment Payment.
	 * @param object                             $order Order.
	 * @param mixed                              $ticket_checkout Ticket checkout.
	 */
	public function __construct( $payment, $order, $ticket_checkout ) {
		parent::__construct( $payment, $order, $ticket_checkout );

		$helper                                 = new WC_WooMercadoPago_Composite_Id_Helper();
		$id                                     = $ticket_checkout['paymentMethodId'];
		$date_expiration                        = $payment->get_option( 'date_expiration', WC_WooMercadoPago_Constants::DATE_EXPIRATION ) . ' days';
		$this->preference                       = $this->make_commum_preference();
		$this->preference['payment_method_id']  = $helper->getPaymentMethodId($id);
		$this->preference['date_of_expiration'] = $this->get_date_of_expiration( $date_expiration );
		$this->preference['transaction_amount'] = $this->get_transaction_amount();
		$this->preference['description']        = implode( ', ', $this->list_of_items );
		$get_payer                              = $this->get_payer_custom();
		unset($get_payer['phone']);
		$this->preference['payer']          = $get_payer;
		$this->preference['payer']['email'] = $this->get_email();

		if ( 'BRL' === $this->site_data[ $this->site_id ]['currency'] ) {
			$this->preference['payer']['identification']['type']   = 14 === strlen( $this->checkout['docNumber'] ) ? 'CPF' : 'CNPJ';
			$this->preference['payer']['identification']['number'] = $this->checkout['docNumber'];
		}

		if ( 'UYU' === $this->site_data[ $this->site_id ]['currency'] ) {
			$this->preference['payer']['identification']['type']   = $ticket_checkout['docType'];
			$this->preference['payer']['identification']['number'] = $ticket_checkout['docNumber'];
		}

		if ( 'webpay' === $ticket_checkout['paymentMethodId'] ) {
			$this->preference['callback_url']                                 = get_site_url();
			$this->preference['transaction_details']['financial_institution'] = '1234';
			$this->preference['additional_info']['ip_address']                = '127.0.0.1';
			$this->preference['payer']['identification']['type']              = 'RUT';
			$this->preference['payer']['identification']['number']            = '0';
			$this->preference['payer']['entity_type']                         = 'individual';
		}

		$this->preference['external_reference']           = $this->get_external_reference();
		$this->preference['additional_info']['items']     = $this->items;
		$this->preference['additional_info']['payer']     = $this->get_payer_custom();
		$this->preference['additional_info']['shipments'] = $this->shipments_receiver_address();

		if (
			isset( $this->checkout['discount'] ) && ! empty( $this->checkout['discount'] ) &&
			isset( $this->checkout['coupon_code'] ) && ! empty( $this->checkout['coupon_code'] ) &&
			$this->checkout['discount'] > 0 && 'woo-mercado-pago-ticket' === WC()->session->chosen_payment_method
		) {
			$this->preference['additional_info']['items'][] = $this->add_discounts();
			$this->preference                               = array_merge( $this->preference, $this->add_discounts_campaign() );
		}

		$internal_metadata            = parent::get_internal_metadata();
		$merge_array                  = array_merge( $internal_metadata, $this->get_internal_metadata_ticket() );
		$this->preference['metadata'] = $merge_array;
		$paymentPlaceId               = $helper->getPaymentPlaceId($id);
		if ( $paymentPlaceId ) {
			$this->preference['metadata']['payment_option_id'] = $paymentPlaceId;
		}
	}

	/**
	 * Get items build array
	 *
	 * @return array
	 */
	public function get_items_build_array() {
		$items = parent::get_items_build_array();
		foreach ( $items as $key => $item ) {
			if ( isset( $item['currency_id'] ) ) {
				unset( $items[ $key ]['currency_id'] );
			}
		}

		return $items;
	}

	/**
	 * Get internal metadata ticket
	 *
	 * @return array
	 */
	public function get_internal_metadata_ticket() {
		return array(
			'checkout'      => 'custom',
			'checkout_type' => 'ticket',
		);
	}
}
