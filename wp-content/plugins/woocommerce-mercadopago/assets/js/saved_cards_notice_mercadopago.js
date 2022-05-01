/* globals ajaxurl */
jQuery(document).ready(function ($) {
    $(document).on('click', '#saved-cards-notice', function () {
        $.post( ajaxurl, { action: 'mercadopago_saved_cards_notice_dismiss' } );
      }
    );
  });
