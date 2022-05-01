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
<p class="mp-details-title">
	<?php echo esc_html( $title_purchase_pix ); ?>
</p>
<div class="mp-details-pix">
	<div class="mp-row-checkout-pix">

		<div class="mp-col-md-4">

			<img src="<?php echo esc_html( $img_pix ); ?>" class="mp-details-pix-img" />

			<p class="mp-details-pix-title">
				<?php echo esc_html( $title_how_to_pay ); ?>
			</p>
			<ul class="mp-steps-congrats mp-pix-left">
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">1</p>
					<p class="mp-details-list-description"><?php echo esc_html( $step_one ); ?></p>
				</li>
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">
						2
					</p>
					<p class="mp-details-list-description"><?php echo esc_html( $step_two ); ?></p>
				</li>
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">
						3
					</p>
					<p class="mp-details-list-description"><?php echo esc_html( $step_three ); ?></p>
				</li>
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">
						4
					</p>
					<p class="mp-details-list-description"><?php echo esc_html( $step_four ); ?></p>
				</li>
			</ul>

		</div>

		<div class="mp-col-md-8 mp-text-center mp-pix-right">
			<p class="mp-details-pix-amount">
				<span class="mp-details-pix-qr">
					<?php echo esc_html( $text_amount ); ?>
					<b><?php echo esc_html( $currency ); ?></b>
				</span>
				<span class="mp-details-pix-qr-value">
					<?php echo esc_html( $amount ); ?>
				</span>
			</p>
			<p class="mp-details-pix-qr-title">
				<?php echo esc_html( $text_scan_qr ); ?>
			</p>
			<img class="mp-details-pix-qr-img" src="data:image/jpeg;base64,<?php echo esc_html( $qr_base64 ); ?>" />
			<p class="mp-details-pix-qr-subtitle">
				<?php echo esc_html( $text_time_qr_one ); ?><?php echo esc_html( $qr_date_expiration ); ?>
			</p>
			<div class="mp-details-pix-container">
				<p class="mp-details-pix-qr-description">
					<?php echo esc_html( $text_description_qr ); ?>
				</p>
				<div class="mp-row-checkout-pix-container">
					<input id="mp-qr-code" value="<?php echo esc_html( $qr_code ); ?>" class="mp-qr-input"></input>
					<button onclick="copy_qr_code()" class="mp-details-pix-button" onclick="true"><?php echo esc_html( $text_button ); ?></button>
					<script>
						function copy_qr_code() {
							var copyText = document.getElementById("mp-qr-code");
							copyText.select();
							copyText.setSelectionRange(0, 99999)
							document.execCommand("copy");
						}
					</script>
				</div>
			</div>
		</div>
	</div>
</div>
