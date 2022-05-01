export default class Deactivation {

	constructor() {
		if ( ! this.set_vars() ) {
			return;
		}

		this.set_events();
	}

	set_vars() {
		this.button_open   = document.querySelector( '[data-slug="{__PLUGIN_SLUG__}"] a[href*="action=deactivate"]' );
		this.modal_wrapper = document.querySelector( '[data-wpdesk-deactivation-modal="{__PLUGIN_SLUG__}"]' );
		if ( ! this.button_open || ! this.modal_wrapper ) {
			return;
		}

		this.button_close  = this.modal_wrapper.querySelector( '[data-wpdesk-deactivation-modal-button-close]' );
		this.button_submit = this.modal_wrapper.querySelector( '[data-wpdesk-deactivation-modal-button-submit]' );
		this.button_skip   = this.modal_wrapper.querySelector( '[data-wpdesk-deactivation-modal-button-skip]' );
		this.form_wrapper  = this.modal_wrapper.querySelector( '[data-wpdesk-deactivation-modal-form]' );

		this.events = {
			open_modal: this.open_modal.bind( this ),
		};
		this.settings = {
			delay_click_deactivate: 10,
		};
		this.status = {
			is_sent: false,
		};

		return true;
	}

	set_events() {
		this.button_open.addEventListener( 'click', this.events.open_modal );

		this.modal_wrapper.addEventListener( 'click', this.close_modal.bind( this, false ) );
		this.button_close.addEventListener( 'click', this.close_modal.bind( this, false ) );
		this.button_skip.addEventListener( 'click', this.close_modal.bind( this, true ) );
		this.form_wrapper.addEventListener( 'click', ( e ) => { e.stopPropagation(); } );

		this.form_wrapper.addEventListener( 'submit', this.init_form_submission.bind( this ) );
	}

	open_modal( e ) {
		e.preventDefault();

		this.button_open.removeEventListener( 'click', this.events.open_modal );
		this.modal_wrapper.removeAttribute( 'hidden' );
	}

	close_modal( is_deactivation, e = null ) {
		e && e.preventDefault();
		const { delay_click_deactivate } = this.settings;

		this.modal_wrapper.setAttribute( 'hidden', 'hidden' );
		if ( is_deactivation ) {
			setTimeout( () => { this.button_open.click(); }, delay_click_deactivate );
		}
	}

	init_form_submission( e ) {
		e.preventDefault();

		this.form_wrapper.removeEventListener( 'submit', this.events.submit_form );
		this.close_modal( true );
		setTimeout( this.submit_form.bind( this ), 0 );
	}

	submit_form() {
		if ( this.status.is_sent ) {
			return;
		}
		this.status.is_sent = true;

		const url     = this.form_wrapper.getAttribute( 'action' );
		const request = new XMLHttpRequest();

		request.open( 'POST', url, true );
		request.send( new FormData( this.form_wrapper ) );
	}
}
