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

<?php
wp_enqueue_script(
		'mercado-pago-js-v2',
		'https://sdk.mercadopago.com/js/v2',
		'',
		WC_WooMercadoPago_Constants::VERSION,
		false
);
?>

<script>
	window.addEventListener("load", function(event) {
		window.mp = new MercadoPago('<?php echo esc_html( $public_key ); ?>');

		window.checkout = window.mp.checkout({
			preference: {
				id: '<?php echo esc_html( $preference_id ); ?>'
			},
			autoOpen: true,
		});
	});
</script>

<a id="submit-payment" href="#" onclick="checkout.open()" class="button alt">
	<?php echo esc_html_e( 'Pay with Mercado Pago', 'woocommerce-mercadopago' ); ?>
</a>
<a class="button cancel" href="<?php echo esc_url( $cancel_url ); ?>">
	<?php echo esc_html_e( 'Cancel &amp; Clear Cart', 'woocommerce-mercadopago' ); ?>
</a>
