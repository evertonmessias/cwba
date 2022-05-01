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

<div>
	<h3 class="mp_subtitle_bd"><?php echo esc_html( $title ); ?></h3>
	<ul class="mp-row-flex">
		<li class="mp-col-md-3 mp-pb-10">
			<p class="mp-number-checkout-body">1</p>
			<p class="mp-text-steps mp-px-20">
				<?php echo esc_html( $step_one_text ); ?>
			</p>
		</li>
		<li class="mp-col-md-3 mp-pb-10">
			<p class="mp-number-checkout-body">2</p>
			<p class="mp-text-steps mp-px-20">
				<?php echo esc_html( $step_two_text_one ); ?>
				<b><?php echo esc_html( $step_two_text_highlight_one ); ?></b>
				<?php echo esc_html( $step_two_text_two ); ?>
				<b><?php echo esc_html( $step_two_text_highlight_two ); ?></b>
			</p>
		</li>
		<li class="mp-col-md-3 mp-pb-10">
			<p class="mp-number-checkout-body">3</p>
			<p class="mp-text-steps mp-px-20">
				<?php echo esc_html( $step_three_text ); ?>
			</p>
		</li>
	</ul>

	<div class="mp-col-md-12 mp-division-line-steps">
		<p class="mp-text-observation mp-gray-text">
			<?php echo esc_html( $observation_one ); ?> </br>
			<?php echo esc_html( $observation_two ); ?>
		</p>
	</div>

	<div class="mp-col-md-12 mp_tienda_link">
		<p class="">
			<a href=<?php echo esc_html( $link_url_one ); ?> target="_blank"><?php echo esc_html( $button_about_pix ); ?></a>
		</p>
	</div>

	<div class="mp-col-md-12 mp-pb-10">
		<p class="mp-text-observation mp-gray-text">
			<?php echo esc_html( $observation_three ); ?>
			<a href=<?php echo esc_html( $link_url_two ); ?> target="_blank"><?php echo esc_html( $link_title_one ); ?></a>
		</p>
	</div>

</div>
