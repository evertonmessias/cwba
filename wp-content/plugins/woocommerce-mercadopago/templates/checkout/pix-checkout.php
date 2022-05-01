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

if ( ! defined('ABSPATH') ) {
	exit;
}
?>

<div class="mp-panel-checkout">
	<?php
	// @codingStandardsIgnoreLine
	echo $checkout_alert_test_mode;
	?>
	<div class="mp-row-checkout">
		<div class="mp-redirect-frame-pix">
			<img src="<?php echo esc_html($image_pix); ?>" class="mp-img-fluid mp-img-redirect" alt="" />
			<p>
				<?php echo esc_html_e('Pay securely and instantly!', 'woocommerce-mercadopago'); ?>
				<br>
				<?php echo esc_html_e('When you finish the order, you will see the code to complete the payment.', 'woocommerce-mercadopago'); ?>
			</p>

		</div>
	</div>
</div>
	<!-- Terms and conditions link at checkout -->
	<div>
		<p class="mp-terms-and-conditions">
			<?php echo esc_html($text_prefix); ?>
			<a target="_blank" href="<?php echo esc_html($link_terms_and_conditions); ?>"> <?php echo esc_html($text_suffix); ?> </a>
		</p>
	</div>
