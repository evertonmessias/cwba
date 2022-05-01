<?php

namespace FcfVendor;

/**
 * @var string                                      $api_url            .
 * @var string                                      $plugin_slug        .
 * @var string                                      $field_name_reason  .
 * @var string                                      $field_name_message .
 * @var WPDesk\DeactivationModal\Model\FormTemplate $form_template      .
 * @var WPDesk\DeactivationModal\Model\FormOptions  $form_options       .
 * @var WPDesk\DeactivationModal\Model\FormValues   $form_values        .
 *
 * @package WPDesk\DeactivationModal
 */
?>

<div class="wpdeskDeactivationModal"
	data-wpdesk-deactivation-modal="<?php 
echo \esc_attr($plugin_slug);
?>"
	hidden>
	<div class="wpdeskDeactivationModal__wrapper">
		<form action="<?php 
echo \esc_url($api_url);
?>"
			method="POST"
			class="wpdeskDeactivationModal__form"
			data-wpdesk-deactivation-modal-form>
			<button type="button"
				class="wpdeskDeactivationModal__close dashicons dashicons-no"
				data-wpdesk-deactivation-modal-button-close></button>

			<div class="wpdeskDeactivationModal__headline">
				<?php 
echo \wp_kses_post($form_template->get_form_title());
?>
			</div>
			<div class="wpdeskDeactivationModal__desc">
				<?php 
echo \wp_kses_post($form_template->get_form_desc());
?>
			</div>

			<ul class="wpdeskDeactivationModal__options">
				<?php 
foreach ($form_options->get_options() as $option) {
    ?>
					<li class="wpdeskDeactivationModal__option">
						<input type="radio"
							name="<?php 
    echo \esc_attr($field_name_reason);
    ?>"
							value="<?php 
    echo \esc_attr($option->get_key());
    ?>"
							id="option-<?php 
    echo \esc_attr($plugin_slug);
    ?>-<?php 
    echo \esc_attr($option->get_key());
    ?>"
							class="wpdeskDeactivationModal__optionInput">
						<label
							for="option-<?php 
    echo \esc_attr($plugin_slug);
    ?>-<?php 
    echo \esc_attr($option->get_key());
    ?>"
							class="wpdeskDeactivationModal__optionLabel">
							<?php 
    echo \esc_html($option->get_label());
    ?>
						</label>
						<div class="wpdeskDeactivationModal__optionExtra">
							<?php 
    if ($option->get_message() !== null) {
        ?>
								<div class="wpdeskDeactivationModal__optionMessage">
									<?php 
        echo \wp_kses_post($option->get_message());
        ?>
								</div>
							<?php 
    }
    ?>
							<?php 
    if ($option->get_question() !== null) {
        ?>
								<textarea class="wpdeskDeactivationModal__optionTextarea"
									name="<?php 
        echo \esc_attr(\sprintf($field_name_message, $option->get_key()));
        ?>"
									placeholder="<?php 
        echo \esc_attr($option->get_question());
        ?>"
									rows="2"></textarea>
							<?php 
    }
    ?>
						</div>
					</li>
				<?php 
}
?>
			</ul>

			<ul class="wpdeskDeactivationModal__buttons">
				<li class="wpdeskDeactivationModal__button">
					<button type="submit"
						class="wpdeskDeactivationModal__buttonInner wpdeskDeactivationModal__buttonInner--blue"
						data-wpdesk-deactivation-modal-button-submit>
						<?php 
echo \esc_html(\__('Submit and Deactivate', 'flexible-checkout-fields'));
?>
					</button>
				</li>
				<li class="wpdeskDeactivationModal__button">
					<button type="button"
						class="wpdeskDeactivationModal__buttonInner wpdeskDeactivationModal__buttonInner--gray"
						data-wpdesk-deactivation-modal-button-skip>
						<?php 
echo \esc_html(\__('Skip and Deactivate', 'flexible-checkout-fields'));
?>
					</button>
				</li>
			</ul>
		</form>
	</div>
</div>
<?php 
