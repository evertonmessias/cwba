<?php

/**
 * Class Flexible_Checkout_Fields_Myaccount_Edit_Address
 */
class Flexible_Checkout_Fields_Myaccount_Edit_Address {

	/**
	 * Plugin.
	 *
	 * @var Flexible_Checkout_Fields_Plugin
	 */
	protected $plugin;

	/**
	 * Flexible_Checkout_Fields_Myaccount_Edit_Address constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin $plugin Plugin.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}


	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'woocommerce_address_to_edit', array( $this, 'filter_edit_address_fields' ), 10, 2 );
	}

	/**
	 * Filter edit address fields.
	 *
	 * @param array  $fields Fields.
	 * @param string $section Section.
	 *
	 * @return array
	 */
	public function filter_edit_address_fields( array $fields, $section ) {
		foreach ( $fields as $key => $field ) {
			$fcf_field = new Flexible_Checkout_Fields_Field( $field, $this->plugin );
			if ( $fcf_field->is_field_excluded_for_user() ) {
				unset( $fields[ $key ] );
			}
		}
		return $fields;
	}

}
