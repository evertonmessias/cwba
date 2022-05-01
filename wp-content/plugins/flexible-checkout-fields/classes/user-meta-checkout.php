<?php
/**
 * User meta hooks.
 *
 * @package Flexible Checkout Fields
 */

/**
 * Handles user meta on checkout.
 */
class Flexible_Checkout_Fields_User_Meta_Checkout {

	/**
	 * Plugin.
	 *
	 * @var Flexible_Checkout_Fields_Plugin
	 */
	protected $plugin;

	/**
	 * .
	 *
	 * @var Flexible_Checkout_Fields_User_Meta
	 */
	private $user_meta;

	/**
	 * Flexible_Checkout_Fields_User_Profile constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin    $plugin Plugin.
	 * @param Flexible_Checkout_Fields_User_Meta $user_meta .
	 */
	public function __construct( Flexible_Checkout_Fields_Plugin $plugin, Flexible_Checkout_Fields_User_Meta $user_meta ) {
		$this->plugin    = $plugin;
		$this->user_meta = $user_meta;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'woocommerce_checkout_update_user_meta', array( $this, 'update_customer_meta_fields_on_checkout' ), 10, 2 );
	}

	/**
	 * Update customer meta data on checkout.
	 *
	 * @param int   $customer_id Customer ID.
	 * @param array $data Posted checkout data.
	 */
	public function update_customer_meta_fields_on_checkout( $customer_id, $data ) {
		$this->user_meta->update_customer_meta_fields( $customer_id, $data );
	}
}
