(function ($) {
    $('.mp-child').change(function () {
        // create var for parent .checkall and group
        let group = $(this).data('group');
        let checkall = $('.mp-selectall[data-group="' + group + '"]');

        // mark selectall as checked if some children are checked
        let someChecked = $('.mp-child[data-group="' + group + '"]:checkbox:checked').length > 0;
        checkall.prop("checked", someChecked);
    }).change();

    // clicking .checkall will check or uncheck all children in the same group
    $('.mp-selectall').click(function () {
        let group = $(this).data('group');
        $('.mp-child[data-group="' + group + '"]').prop('checked', this.checked).change();
    });
}(window.jQuery));
