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

?>
<div class="mp-wallet-button-preview">
	<br/>
	<p class="description"><?php echo esc_html( $img_wallet_button_description ); ?></p>
	<br/>
	<img src="<?php echo esc_url( $img_wallet_button_uri ); ?>">
</div>
