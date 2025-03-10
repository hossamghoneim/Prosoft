$('#form_repeater').repeater({
    initEmpty: false,
    isFirstItemUndeletable: true,
    show: function () {
        $(this).slideDown();

        if ( window['addNewBrandingCallback'] !== undefined )
            window['addNewBrandingCallback']($(this))
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});
