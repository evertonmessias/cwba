<?php

namespace WPDesk\FCF\Free\Tracker;

use FcfVendor\WPDesk\DeactivationModal;
use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FcfVendor\WPDesk_Plugin_Info;
use WPDesk\FCF\Free\Settings\Form\EditFieldsForm;
use WPDesk\FCF\Free\Settings\Option\CustomFieldOption;

/**
 * Handles the modal displayed when the plugin is deactivated.
 */
class DeactivationTracker implements Hookable {

	const PLUGIN_SLUG            = 'flexible-checkout-fields';
	const ACTIVATION_OPTION_NAME = 'plugin_activation_%s';

	/**
	 * @var WPDesk_Plugin_Info
	 */
	private $plugin_info;

	/**
	 * @param WPDesk_Plugin_Info $plugin_info .
	 */
	public function __construct( WPDesk_Plugin_Info $plugin_info ) {
		$this->plugin_info = $plugin_info;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'plugins_loaded', [ $this, 'load_deactivation_modal' ] );
	}

	/**
	 * @return void
	 * @internal
	 */
	public function load_deactivation_modal() {
		new DeactivationModal\Modal(
			self::PLUGIN_SLUG,
			( new DeactivationModal\Model\FormTemplate( $this->plugin_info->get_plugin_name() ) ),
			( new DeactivationModal\Model\FormOptions() )
				->set_option(
					new DeactivationModal\Model\FormOption(
						'plugin_not_working',
						10,
						__( 'The plugin does not work properly', 'flexible-checkout-fields' ),
						sprintf(
						/* translators: %1$s: anchor opening tag, %2$s: anchor closing tag, %3$s: anchor opening tag, %4$s: anchor closing tag */
							__( 'Contact us on %1$sthe support forum%2$s or read %3$sthe plugin FAQ%4$s for help.', 'flexible-checkout-fields' ),
							'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-doesnt-work-properly-support-forum' ) ) . '" target="_blank">',
							'</a>',
							'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-doesnt-work-properly-faq' ) ) . '" target="_blank">',
							'</a>'
						),
						__( 'Please tell us what was the problem.', 'flexible-checkout-fields' )
					)
				)
				->set_option(
					new DeactivationModal\Model\FormOption(
						'difficult_to_use',
						20,
						__( 'The plugin is difficult to use', 'flexible-checkout-fields' ),
						sprintf(
						/* translators: %1$s: anchor opening tag, %2$s: anchor closing tag, %3$s: anchor opening tag, %4$s: anchor closing tag */
							__( 'Check %1$sthe documentation%2$s or contact us on %3$sthe support forum%4$s for help.', 'flexible-checkout-fields' ),
							'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-plugin-is-difficult-docs' ) ) . '" target="_blank">',
							'</a>',
							'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-plugin-is-difficult-support-forum' ) ) . '" target="_blank">',
							'</a>'
						),
						__( 'How can we do it better? Please write what was problematic.', 'flexible-checkout-fields' )
					)
				)
				->set_option(
					new DeactivationModal\Model\FormOption(
						'not_meet_requirements',
						30,
						__( 'The plugin does not meet all the requirements', 'flexible-checkout-fields' ),
						null,
						__( 'Please write what function is missing.', 'flexible-checkout-fields' )
					)
				)
				->set_option(
					new DeactivationModal\Model\FormOption(
						'found_better_plugin',
						40,
						__( 'I found a better plugin', 'flexible-checkout-fields' ),
						null,
						__( 'Please write what plugin is it and what was the reason for choosing it.', 'flexible-checkout-fields' )
					)
				)
				->set_option(
					new DeactivationModal\Model\FormOption(
						'no_longer_need',
						50,
						__( 'The plugin is no longer needed', 'flexible-checkout-fields' ),
						null,
						__( 'What is the reason for that?', 'flexible-checkout-fields' )
					)
				)
				->set_option(
					new DeactivationModal\Model\FormOption(
						'temporary_deactivation',
						60,
						__( 'It\'s a temporary deactivation (I\'m just debugging an issue)', 'flexible-checkout-fields' )
					)
				)
				->set_option(
					new DeactivationModal\Model\FormOption(
						'other',
						70,
						__( 'Other', 'flexible-checkout-fields' ),
						null,
						__( 'Please tell us what made you click this option.', 'flexible-checkout-fields' )
					)
				),
			( new DeactivationModal\Model\FormValues() )
				->set_value(
					new DeactivationModal\Model\FormValue(
						'is_localhost',
						[ $this, 'is_localhost' ]
					)
				)
				->set_value(
					new DeactivationModal\Model\FormValue(
						'plugin_using_time',
						[ $this, 'get_time_of_plugin_using' ]
					)
				)
				->set_value(
					new DeactivationModal\Model\FormValue(
						'settings_saved',
						[ $this, 'check_if_plugin_settings_saved' ]
					)
				)
				->set_value(
					new DeactivationModal\Model\FormValue(
						'custom_fields_added',
						[ $this, 'check_if_custom_field_created' ]
					)
				),
			new DeactivationModal\Sender\DataWpdeskSender(
				$this->plugin_info->get_plugin_file_name(),
				$this->plugin_info->get_plugin_name()
			)
		);
	}

	/**
	 * @internal
	 */
	public function is_localhost(): bool {
		return ( in_array( $_SERVER['REMOTE_ADDR'] ?? '', [ '127.0.0.1', '::1' ], true ) );
	}

	/**
	 * @return string|null
	 * @internal
	 */
	public function get_time_of_plugin_using() {
		$option_activation = sprintf( self::ACTIVATION_OPTION_NAME, $this->plugin_info->get_plugin_file_name() );
		$activation_date   = get_option( $option_activation, null );
		if ( $activation_date === null ) {
			return null;
		}

		$current_date = current_time( 'mysql' );
		return ( strtotime( $current_date ) - strtotime( $activation_date ) );
	}

	/**
	 * @internal
	 */
	public function check_if_plugin_settings_saved(): bool {
		$settings = get_option( EditFieldsForm::SETTINGS_OPTION_NAME, null );
		return ( $settings !== null );
	}

	/**
	 * @internal
	 */
	public function check_if_custom_field_created(): bool {
		$settings = get_option( EditFieldsForm::SETTINGS_OPTION_NAME, [] );
		foreach ( $settings as $section_fields ) {
			foreach ( $section_fields as $section_field ) {
				if ( $section_field[ CustomFieldOption::FIELD_NAME ] ?? false ) {
					return true;
				}
			}
		}
		return false;
	}
}
