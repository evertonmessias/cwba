<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-checkout-fields/fields/image.php
 *
 * @var string  $key   Field ID.
 * @var mixed[] $args  Custom attributes for field.
 * @var mixed   $value Field value.
 * @var string[] $custom_attributes .
 *
 * @package Flexible Checkout Fields
 */

?>
<p class="form-heading form-row <?php echo esc_attr( $args['class'] ); ?>"
	id="<?php echo esc_attr( $key ); ?>_field"
	data-priority="<?php echo esc_attr( $args['priority'] ); ?>"
	data-fcf-field="<?php echo esc_attr( $key ); ?>">
	<?php
	echo wp_get_attachment_image(
		$args['image'],
		[ $args['image_width'], $args['image_width'] ],
		false,
		[
			'alt' => esc_attr( $args['label'] ),
		]
	);
	?>
</p>
