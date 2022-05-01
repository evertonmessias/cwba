<?php

namespace WPDesk\FCF\Free\Integration;

/**
 * .
 */
interface ValueInterface {

	/**
	 * Returns value of order field.
	 *
	 * @param string $field_key Field key.
	 * @param int    $order_id  ID of WC_Order.
	 *
	 * @return mixed Value of field, or null if not exists.
	 */
	public function get_field_value( string $field_key, int $order_id );
}
