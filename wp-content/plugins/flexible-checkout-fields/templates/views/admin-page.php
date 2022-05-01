<?php
/**
 * Template of plugin admin page.
 *
 * @var array $settings      Data for window.reactInit variable.
 * @var array $menu_tabs     List of items for primary nav.
 * @var array $menu_sections List of items for second nav.
 * @package Flexible Checkout Fields
 */

?>

<div class="wrap">
	<hr class="wp-header-end">
	<div class="fcfSettings">
		<ul class="fcfSettings__columns">
			<li class="fcfSettings__column">
				<div class="fcfSettings__headline">
					<?php echo esc_html__( 'Flexible Checkout Fields', 'flexible-checkout-fields' ); ?>
				</div>
			</li>
		</ul>
		<ul class="fcfSettings__columns">
			<li class="fcfSettings__column">
				<div class="fcfWidget">
					<div class="fcfWidget__inner">
						<div class="fcfTabs">
							<ul class="fcfTabs__items">
								<?php foreach ( $menu_tabs as $menu_tab ) : ?>
									<li class="fcfTabs__item">
										<a href="<?php echo esc_url( $menu_tab['url'] ); ?>"
											class="fcfTabs__itemLink <?php echo ( $menu_tab['is_active'] ) ? 'fcfTabs__itemLink--active' : ''; ?>">
											<?php echo esc_html( $menu_tab['label'] ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<?php if ( $menu_sections ) : ?>
					<div class="fcfTabs fcfTabs--small fcfTabs--lines">
						<ul class="fcfTabs__items">
							<?php foreach ( $menu_sections as $menu_section ) : ?>
								<li class="fcfTabs__item">
									<a href="<?php echo esc_url( $menu_section['url'] ); ?>"
										class="fcfTabs__itemLink <?php echo ( $menu_section['is_active'] ) ? 'fcfTabs__itemLink--active' : ''; ?>">
										<?php echo esc_html( $menu_section['label'] ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</li>
		</ul>
		<div id="fcf-settings"></div>
		<ul class="fcfSettings__columns fcfSettings__columns--margin">
			<li class="fcfSettings__column">
				<div class="fcfSettings__footer">
					<?php
					echo wp_kses_post(
						sprintf(
						/* translators: %$1s: love icon, %$2s: anchor opening tag, %$3s: anchor closing tag, %$4s: anchor opening tag, %$5s: anchor closing tag */
							__( 'Created with %1$s by Rangers from %2$sWP Desk%3$s - if you like FCF %4$srate us%5$s', 'flexible-checkout-fields' ),
							'<span class="fcfSettings__footerIcon fcfSettings__footerIcon--heart"></span>',
							'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-footer-wpdesk-link' ) ) . '" target="_blank">',
							'</a>',
							'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-footer-review-link' ) ) . '" target="_blank">',
							'<span class="fcfSettings__footerIcon fcfSettings__footerIcon--star"></span>
									<span class="fcfSettings__footerIcon fcfSettings__footerIcon--star"></span>
									<span class="fcfSettings__footerIcon fcfSettings__footerIcon--star"></span>
									<span class="fcfSettings__footerIcon fcfSettings__footerIcon--star"></span>
									<span class="fcfSettings__footerIcon fcfSettings__footerIcon--star"></span>
								</a>'
						)
					);
					?>
				</div>
			</li>
		</ul>
	</div>
</div>

<script>
	window.reactInit = <?php echo json_encode( $settings ); ?>;
</script>
