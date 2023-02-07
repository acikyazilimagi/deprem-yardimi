(function ($) {

	"use strict";

	// =====================================================
	//      PRELOADER
	// =====================================================
	$(window).on('load', function () {
		'use strict';
		$('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
		$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
	});

	// =====================================================
	//      BACK TO TOP BUTTON
	// =====================================================
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

	// =====================================================
	//      NAVBAR
	// =====================================================
	$(window).on('scroll load', function () {

		if ($(window).scrollTop() >= 1) {
			$('.main-header').addClass('active');
		} else {
			$('.main-header').removeClass('active');
		}

	});

	// =====================================================
	//      STICKY SIDEBAR SETUP
	// =====================================================
	$('#mainContent, #sidebar').theiaStickySidebar({
		additionalMarginTop: 90
	});

	// =====================================================
	//      MOBILE MENU
	// =====================================================	
	var $menu = $("nav#menu").mmenu({
		"extensions": ["pagedim-black", "theme-white"], // "theme-dark" can be changed to: "theme-white"
		counters: true,
		keyboardNavigation: {
			enable: true,
			enhance: true
		},
		navbar: {
			title: 'MENU'
		},
		navbars: [{ position: 'bottom', content: ['<a href="#">© 2020 Sendy</a>'] }]
	},
		{
			// configuration
			clone: true,
		});
	var $icon = $("#hamburger");
	var API = $menu.data("mmenu");
	$icon.on("click", function () {
		API.open();
	});
	API.bind("open:finish", function () {
		setTimeout(function () {
			$icon.addClass("is-active");
		}, 100);
	});
	API.bind("close:finish", function () {
		setTimeout(function () {
			$icon.removeClass("is-active");
		}, 100);
	});

	// =====================================================
	//      DROPDOWN MANAGEMENT
	// =====================================================
	$('select').niceSelect();

	// Function for saving the selected dropdown item
	function saveSelectedDropdownItem() {

		// Get the actual value
		var selectedSubject = $('#subjectList option:selected').text();

		// Update hidden field
		$('#subject').val(selectedSubject);
	}

	// When subject is changed, get the new selected item
	$('#subjectList').on('change', function () {
		saveSelectedDropdownItem();
	});

	// =====================================================
	//      FILEPOND FILE UPLOAD
	// =====================================================

	// Register plugins
	FilePond.registerPlugin(
		FilePondPluginFileValidateSize,
		FilePondPluginFileValidateType
	);

	// Set default FilePond options
	FilePond.setOptions({

		// Maximum files
		maxFiles: 1,

		// Maximum allowed file size
		maxFileSize: '1MB',

		// Allowed file types
		acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],

		// Upload to this server end point
		server: 'php/'
	});

	// Turn a file input into a file pond
	FilePond.create(document.querySelector('input[type="file"]'));

	// =====================================================
	//      FORM INPUT VALIDATION
	// =====================================================
	$('#contactForm').parsley();

	$('#contactForm').parsley().on('field:success', function() { 
		$('ul.parsley-errors-list').not(':has(li)').remove();
	});

})(window.jQuery);