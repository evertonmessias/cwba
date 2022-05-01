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

<div style="text-align: center;">
	<div>
	<img style="border: none;
				display: inline-block;
				font-size: 14px;
				font-weight: bold;
				outline: none;
				text-decoration: none;
				text-transform: capitalize;
				vertical-align: middle;
				max-width: 100%;
				width: 168px;
				height: 168px;
				margin: 0 0 10px;"
				src="<?php esc_html_e( $qr_code_image, 'woocommerce-mercadopago' ); ?>" alt="pix">
	</div>

	<div style="margin: 0 0 16px;
				border: none;
				display: inline-block;
				font-size: 14px;
				font-weight: bold;
				outline: none;
				text-decoration: none;
				text-transform: capitalize;
				vertical-align: middle;
				max-width: 100%;">
		<small><?php esc_html_e( $text_expiration_date, 'woocommerce-mercadopago' ) . esc_html_e( $expiration_date, 'woocommerce-mercadopago' ); ?></small>
	</div>

	<div style="margin-left: auto;
			margin-right: auto;
			width: 320px;
			word-break: break-word;
			font-size: 10px;">
		<p>
			<?php esc_html_e( $qr_code, 'woocommerce-mercadopago' ); ?>
		</p>
	</div>
</div>
