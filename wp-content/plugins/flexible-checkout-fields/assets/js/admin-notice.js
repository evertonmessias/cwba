jQuery( document ).ready( function() {

	var notice_selector       = '[data-notice="fcf-admin-notice"]';
	var button_close_selector = '.notice-dismiss';
	var button_hide_selector  = '[data-notice-button]';

	var notice_wrapper = document.querySelector( notice_selector );
	if ( ! notice_wrapper ) {
		return;
	}

	var close_notice = function ( is_permanently ) {
		jQuery.ajax(
			notice_wrapper.getAttribute( 'data-notice-url' ),
			{
				type: 'POST',
				data: {
					action: notice_wrapper.getAttribute( 'data-notice-action' ),
					is_permanently: ( is_permanently ) ? 1 : 0,
				},
			}
		);

		if ( is_permanently ) {
			notice_wrapper.querySelector( button_close_selector ).click();
		}
	}

	var click_on_close = function( e ) {
		notice_wrapper.removeEventListener( 'click', click_on_close );

		if ( e.target.matches( button_close_selector ) ) {
			close_notice( false );
		} else if ( e.target.matches( button_hide_selector ) ) {
			close_notice( true );
		}
	}

	notice_wrapper.addEventListener( 'click', click_on_close );

} );
