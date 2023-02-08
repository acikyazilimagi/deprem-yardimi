(function ($) {

    "use strict";

    $(window).on('load', function () {
        'use strict';
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.

        $("#address_form_floor").mask('000');
        $("#address_form_phone").mask('0 (000) 000 00 00');
    });

})(window.jQuery);
