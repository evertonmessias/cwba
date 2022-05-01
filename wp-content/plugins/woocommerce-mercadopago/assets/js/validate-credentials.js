(
	function ( $ ) {
		$( document ).ready( function () {
			mercado_pago_credentials.process(
				jQuery( '[id*=\'public_key_prod\']' ),
				jQuery( '[id*=\'access_token_prod\']' )
			);
			mercado_pago_credentials.process(
				jQuery( '[id*=\'public_key_test\']' ),
				jQuery( '[id*=\'access_token_test\']' )
			);
		} );

		var mercado_pago_credentials = {
			/**
			 * Call validate has any data
			 * @param public_key
			 * @param access_token
			 */
			process: function ( public_key, access_token ) {
				if ( public_key.val() !== '' && access_token.val() !== '' ) {
					this.validate( public_key, access_token );
				}
			},
			/**
			 * Validate
			 * @param public_key
			 * @param access_token
			 */
			validate: function ( public_key, access_token ) {
				$.post( ajaxurl, {
					'action': 'mercadopago_validate_credentials',
					'public_key': public_key.val(),
					'access_token': access_token.val()
				}, function ( response ) {
					if ( response.success ) {
						access_token.removeClass( 'mp_credential_input_loading' ).addClass( 'mp_credential_input_success' );
						public_key.removeClass( 'mp_credential_input_loading' ).addClass( 'mp_credential_input_success' );
						return;
					}
					access_token.removeClass( 'mp_credential_input_loading' ).addClass( 'mp_credential_input_warning' );
					public_key.removeClass( 'mp_credential_input_loading' ).addClass( 'mp_credential_input_warning' );
				} );
			},
		};
	}( jQuery )
);
