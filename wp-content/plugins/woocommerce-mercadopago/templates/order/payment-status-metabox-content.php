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

<p style="font-family: 'Lato', sans-serif; font-size: 14px;">
	<?php
		// @codingStandardsIgnoreStart
		echo __( 'This is the payment status of your Mercado Pago Activities. To check the order status, please refer to Order details.', 'woocommerce-mercadopago' );
		// @codingStandardsIgnoreEnd
	?>
</p>

<div class='mp-alert-checkout-test-mode' style='border-left: 5px solid <?php echo esc_html( $border_left_color ); ?>; min-height: 70px;'>
	<div class='mp-alert-icon-checkout-test-mode' style='width: 0 !important; padding: 0 10px;'>
		<img
			src="<?php echo esc_html( $img_src ); ?>"
			alt='alert'
			class='mp-alert-circle-img'
		>
	</div>
	<div class='mp-alert-texts-checkout-test-mode'>
		<h2 class='mp-alert-title-checkout-test-mode' style="font-weight: 700; padding: 12px 0 0 0; font-family: 'Lato', sans-serif; font-size: 16px">
			<?php echo esc_html( $alert_title ); ?>
		</h2>
		<p class='mp-alert-description-checkout-test-mode' style="font-family: 'Lato', sans-serif;">
			<?php echo esc_html( $alert_description ); ?>
		</p>
		<p style="margin: 5px 0">
			<a href="<?php echo esc_html( $link ); ?>" target="__blank" style="color: #009EE3; text-decoration: none; font-family: 'Lato', sans-serif;">
				<?php echo esc_html( $link_description ); ?>
			</a>
		</p>
	</div>
</div>
