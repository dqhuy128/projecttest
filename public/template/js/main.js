// menu header
function mobileMenu() {
	$('.menu-hamburger').click(function () {
		$(this).siblings('.menu-overlay').addClass('active');
		$(this).siblings('.menu-items').addClass('active');
	});

	$('.menu-parent').click(function () {
		$(this).find('i').toggleClass('active');
	});

	$(document).mouseup(function (e) {
		if (
			!$('.menu-items').is(e.target) &&
			$('.menu-items').has(e.target).length === 0
		) {
			$('.menu-items').siblings('.menu-overlay').removeClass('active');
			$('.menu-items').removeClass('active');
		}
	});

	$('.menu-parent').on('click', 'i', function () {
		$(this).parent().siblings('.menu-sub').slideToggle();
	});
}

// header fixed scroll

function headerScroll() {
	let headerHeight = $('.header').innerHeight();

	$('#js-margin-top').css('margin-top', headerHeight);
}

// initialize wow js

function initWow() {
	new WOW().init();
}

// scroll to id when click menu item
function scrollToId() {
	var windowBreakpoint = $(window).width();

	$('.js-scrollId').click(function () {
		let dataSection = $(this).data('section');

		$('html, body').animate(
			{
				scrollTop: $('.' + dataSection).offset().top - 70
			},
			1000
		);
	});

	if (windowBreakpoint < 992) {
		$('.js-scrollId').click(function () {
			$('.menu-items').siblings('.menu-overlay').removeClass('active');
			$('.menu-items').removeClass('active');
		});
	}
}

$(document).ready(function () {
	mobileMenu();
	headerScroll();
	scrollToId();
	initWow();
});
