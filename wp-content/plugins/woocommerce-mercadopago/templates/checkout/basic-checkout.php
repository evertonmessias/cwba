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
<div class="mp-panel-checkout">
	<?php
		// @codingStandardsIgnoreLine
		echo $checkout_alert_test_mode;
	?>
	<div class="mp-row-checkout">
	<?php if ( 0 !== (int) $credito ) : ?>
	<div id="framePayments" class="mp-col-md-12">
		<div class="frame-tarjetas">
			<p class="mp-subtitle-basic-checkout">
				<?php echo esc_html_e( 'Credit cards', 'woocommerce-mercadopago' ); ?>
				<span class="mp-badge-checkout"><?php echo esc_html_e( 'Until', 'woocommerce-mercadopago' ); ?> <?php echo esc_html( $installments ); ?>
				<?php if ( '1' === $installments ) : ?>
					<?php echo esc_html_e( 'installment', 'woocommerce-mercadopago' ); ?>
				<?php else : ?>
					<?php echo esc_html_e( 'installments', 'woocommerce-mercadopago' ); ?>
				<?php endif; ?></span>
			</p>
			<?php foreach ( $tarjetas as $tarjeta ) : ?>
				<?php if ( 'credit_card' === $tarjeta['type'] ) : ?>
				<img src="<?php echo esc_html( $tarjeta['image'] ); ?>" class="mp-img-fluid mp-img-tarjetas" alt=""/>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( 0 !== $debito ) : ?>
	<div id="framePayments" class="mp-col-md-6 mp-pr-15">
		<div class="frame-tarjetas">
			<p class="submp-title-checkout"><?php echo esc_html_e( 'Debit card', 'woocommerce-mercadopago' ); ?></p>

			<?php foreach ( $tarjetas as $tarjeta ) : ?>
				<?php if ( 'debit_card' === $tarjeta['type'] || 'prepaid_card' === $tarjeta['type'] ) : ?>
				<img src="<?php echo esc_html( $tarjeta['image'] ); ?>" class="mp-img-fluid mp-img-tarjetas" alt="" />
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( 0 !== $efectivo ) : ?>
	<div id="framePayments" class="mp-col-md-6">
		<div class="frame-tarjetas">
			<p class="submp-title-checkout"><?php echo esc_html_e( 'Payments in cash', 'woocommerce-mercadopago' ); ?></p>

			<?php foreach ( $tarjetas as $tarjeta ) : ?>
				<?php if ( 'credit_card' !== $tarjeta['type'] && 'debit_card' !== $tarjeta['type'] && 'prepaid_card' !== $tarjeta['type'] ) : ?>
				<img src="<?php echo esc_html( $tarjeta['image'] ); ?>" class="mp-img-fluid mp-img-tarjetas" alt=""/>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( 'redirect' === $method ) : ?>
	<div class="mp-col-md-12 mp-pt-20">
		<div class="mp-redirect-frame">
			<img src="<?php echo esc_html( $cho_image ); ?>" class="mp-img-fluid mp-img-redirect" alt=""/>
			<p><?php echo esc_html_e( 'We take you to our site to complete the payment', 'woocommerce-mercadopago' ); ?></p>
		</div>
	</div>
	<?php endif; ?>

	</div>
</div>
<!-- Terms and conditions link at checkout -->
<div>
	<p class="mp-terms-and-conditions">
		<?php echo esc_html($text_prefix); ?>
		<a target="_blank" href="<?php echo esc_html($link_terms_and_conditions); ?>">  <?php echo esc_html($text_suffix); ?> </a>
	</p>
</div>
