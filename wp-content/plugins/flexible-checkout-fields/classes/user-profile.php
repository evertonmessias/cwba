<?php
/**
 * User profile hooks.
 *
 * @package Flexible Checkout Fields
 */

/**
 * User profile hooks.
 *
 * Class Flexible_Checkout_Fields_User_Profile
 */
class Flexible_Checkout_Fields_User_Profile {

	const FIELD_TYPE = 'type';
	const FIELD_TYPE_SELECT = 'select';

	const FIELD_TYPE_INSPIRECHECKBOX = 'inspirecheckbox';
	const FIELD_TYPE_INSPIRERADIO = 'inspireradio';

	const FIELD_COPY_BILLING = 'copy_billing';

	/**
	 * Plugin.
	 *
	 * @var Flexible_Checkout_Fields_Plugin
	 */
	protected $plugin;

	/**
	 * .
	 *
	 * @var Flexible_Checkout_Fields_User_Meta
	 */
	private $user_meta;

	/**
	 * Flexible_Checkout_Fields_User_Profile constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin    $plugin Plugin.
	 * @param Flexible_Checkout_Fields_User_Meta $user_meta .
	 */
	public function __construct( Flexible_Checkout_Fields_Plugin $plugin, Flexible_Checkout_Fields_User_Meta $user_meta ) {
		$this->plugin    = $plugin;
		$this->user_meta = $user_meta;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'show_user_profile', [ $this, 'add_custom_user_fields_admin' ], 75 );
		add_action( 'edit_user_profile', [ $this, 'add_custom_user_fields_admin' ], 75 );

		add_action( 'personal_options_update', [ $this, 'save_custom_user_fields_admin' ] );
		add_action( 'edit_user_profile_update', [ $this, 'save_custom_user_fields_admin' ] );
	}

	/**
	 * Add custom fields to edit user admin /wp-admin/profile.php.
	 *
	 * @param mixed $user .
	 *
	 * @return void
	 */
	public function add_custom_user_fields_admin( $user ) {
		$settings = $this->plugin->get_settings();
		$sections = $this->plugin->sections;
		if ( ! $settings ) {
			return;
		}

		foreach ( $settings as $key => $type ) {
			if ( ! $this->user_meta->is_fcf_section( $key )
				|| ! $this->user_meta->is_section_allowed_for_usermeta( $key )
				|| ! is_array( $type ) ) {
				continue;
			}

			$section_data = $sections[ $key ] ?? ( $sections[ 'woocommerce_' . $key ] ?? null );
			if ( $section_data === null ) {
				continue;
			}

			echo '<h3>' . esc_html( $section_data['tab_title'] ) . '</h3>';
			echo '<div class="fcf-admin-fields postbox">';
			echo '<div class="inside">';
			foreach ( $type as $field ) {
				if ( isset( $field['visible'] ) && 0 === intval( $field['visible'] )
					&& ( isset( $field['custom_field'] ) && 1 === intval( $field['custom_field'] ) ) ) {
					$field_value = htmlspecialchars_decode( get_the_author_meta( $field['name'], $user->ID ) );

					echo apply_filters( 'flexible_checkout_fields_form_field', '', $field['name'], $field, $field_value );
				}
			}
			echo '</div>';
			echo '</div>';
		}
	}

	/**
	 * Save custom user fields in admin.
	 *
	 * @param int $user_id User ID.
	 */
	public function save_custom_user_fields_admin( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}
		if ( wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) { // phpcs:ignore
			$this->user_meta->update_customer_meta_fields( $user_id, $_POST );
		}
	}
}
