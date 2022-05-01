<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-checkout-fields/fields/colorpicker.php
 *
 * @var string   $key               Field ID.
 * @var mixed[]  $args              Custom attributes for field.
 * @var mixed    $value             Field value.
 * @var string[] $custom_attributes .
 *
 * @package Flexible Checkout Fields
 */

?>
<p class="form-row <?php echo esc_attr( $args['class'] ); ?>"
	id="<?php echo esc_attr( $key ); ?>_field"
	data-priority="<?php echo esc_attr( $args['priority'] ); ?>"
	data-fcf-field="<?php echo esc_attr( $key ); ?>">
	<label for="<?php echo esc_attr( $key ); ?>">
		<?php echo wp_kses( $args['label'], '' ); ?>
		<?php if ( $args['required'] ) : ?>
			<abbr class="required"
				title="<?php echo esc_attr( __( 'Required Field', 'flexible-checkout-fields' ) ); ?>">*</abbr>
		<?php endif; ?>
	</label>
	<input
		type="text"
		class="input-text fcf-load-colorpicker"
		name="<?php echo esc_attr( $key ); ?>"
		id="<?php echo esc_attr( $key ); ?>"
		placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
		data-fcf-field-input="<?php echo esc_attr( $key ); ?>"
	<?php foreach ( $custom_attributes as $attr_key => $attr_value ) : ?>
		<?php echo esc_attr( $attr_key ); ?>="<?php echo esc_attr( $attr_value ); ?>"
	<?php endforeach; ?> />
</p>
