// Redirect
function delayedRedirect()	{
    window.location = 'https://ultimatewebsolutions.net/sendy/'
}

(function ($) {

    "use strict";

    $(window).on('load', function () {
        'use strict';
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
    });

    function scrollToTop() {
        $('html, body').animate({ scrollTop: 0 }, 500, 'easeInOutExpo');
    }

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 100) {
            $('#toTop').fadeIn('slow');
        } else {
            $('#toTop').fadeOut('slow');
        }
    });

    $('#toTop').on('click', function () {
        scrollToTop();
        return false;
    });


    $(window).on('scroll load', function () {

        if ($(window).scrollTop() >= 1) {
            $('.main-header').addClass('active');
        } else {
            $('.main-header').removeClass('active');
        }

    });
})(window.jQuery);
