(function ($) {

    "use strict";

    $(window).on('load', function () {
        'use strict';
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
    });

})(window.jQuery);
