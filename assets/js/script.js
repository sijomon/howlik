$(document).ready(function ()
{
	/*==================================
	 Carousel 
	 ==================================*/

	// Featured Listings  carousel || HOME PAGE
	var owlitem = $(".item-carousel");

	owlitem.owlCarousel({
		//navigation : true, // Show next and prev buttons
		navigation: false,
		pagination: true,
		items: 5,
		itemsDesktopSmall: [979, 3],
		itemsTablet: [768, 3],
		itemsTabletSmall: [660, 2],
		itemsMobile: [400, 1]


	});

	// Custom Navigation Events
	$("#nextItem").click(function () {
		owlitem.trigger('owl.next');
	});
	$("#prevItem").click(function () {
		owlitem.trigger('owl.prev');
	});


	// Featured Listings  carousel || HOME PAGE
	var featuredListSlider = $(".featured-list-slider");

	featuredListSlider.owlCarousel({
		//navigation : true, // Show next and prev buttons
		navigation: false,
		pagination: false,
		items: 5,
		itemsDesktopSmall: [979, 3],
		itemsTablet: [768, 3],
		itemsTabletSmall: [660, 2],
		itemsMobile: [400, 1]
	});

	// Custom Navigation Events
	$(".featured-list-row .next").click(function () {
		featuredListSlider.trigger('owl.next');
	});
	$(".featured-list-row .prev").click(function () {
		featuredListSlider.trigger('owl.prev');
	});


	/*==================================
	 Ajax Tab || CATEGORY PAGE
	 ==================================*/

	$("#ajaxTabs li > a").click(function () {

		$("#allAds").empty().append("<div id='loading text-center'> <br> <img class='center-block' src='images/loading.gif' alt='Loading' /> <br> </div>");
		$("#ajaxTabs li").removeClass('active');
		$(this).parent('li').addClass('active');
		$.ajax({
			url: this.href, success: function (html) {
				$("#allAds").empty().append(html);
				$('.tooltipHere').tooltip('hide');
			}
		});
		return false;
	});

	urls = $('#ajaxTabs li:first-child a').attr("href");
	//alert(urls);
	$("#allAds").empty().append("<div id='loading text-center'> <br> <img class='center-block' src='images/loading.gif' alt='Loading' /> <br>  </div>");
	$.ajax({
		url: urls, success: function (html) {
			$("#allAds").empty().append(html);
			$('.tooltipHere').tooltip('hide');
		}
	});


	/*==================================
	 List view clickable || CATEGORY 
	 ==================================*/

	/* Default view */
	var searchDisplayMode = readCookie('searchDisplayModeCookie');
	if (searchDisplayMode) {
		if (searchDisplayMode == 'grid') {
			gridView('.grid-view');
		} else if (searchDisplayMode == 'list') {
			listView('.list-view');
		} else if (searchDisplayMode == 'compact') {
			compactView('.compact-view');
		}
	} else {
		createCookie('searchDisplayModeCookie', 'grid', 7);
	}

	// List view , Grid view  and compact view

	$('.list-view,#ajaxTabs li a').click(function (e) { /* use a class, since your ID gets mangled */
		e.preventDefault();
		listView('.list-view');
		createCookie('searchDisplayModeCookie', 'list', 7);
	});

	$('.grid-view').click(function (e) { /* use a class, since your ID gets mangled */
		e.preventDefault();
		gridView(this);
		createCookie('searchDisplayModeCookie', 'grid', 7);
	});

	$('.compact-view').click(function (e) { /* use a class, since your ID gets mangled */
		e.preventDefault();
		compactView(this);
		createCookie('searchDisplayModeCookie', 'compact', 7);
	});

	$(function () {
		$('.row-featured .f-category').matchHeight();
		$.fn.matchHeight._apply('.row-featured .f-category');
	});

	$(function () {
		$('.has-equal-div > div').matchHeight();
		$.fn.matchHeight._apply('.row-featured .f-category');
	});


	/*==================================
	 Global Plugins ||
	 ==================================*/

	$('.long-list').hideMaxListItems({
		'max': 8,
		'speed': 500,
		'moreText': 'View More ([COUNT])'
	});

	$('.long-list-user').hideMaxListItems({
		'max': 12,
		'speed': 500,
		'moreText': 'View More ([COUNT])'
	});

	$('.long-list-home').hideMaxListItems({
		'max': 3,
		'speed': 500,
		'moreText': langLayout.hideMaxListItems.moreText + ' ([COUNT])',
		'lessText': langLayout.hideMaxListItems.lessText
	});


	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

	$(".scrollbar").scroller(); // custom scroll bar plugin


	/*=======================================================================================
	 cat-collapse Hmepage Category Responsive view
	 =======================================================================================*/

	$(window).bind('resize load', function () {

		if ($(this).width() < 767) {
			$('.cat-collapse').collapse('hide');
			$('.cat-collapse').on('shown.bs.collapse', function () {
				$(this).prev('.cat-title').find('.icon-down-open-big').addClass("active-panel");
			});
			$('.cat-collapse').on('hidden.bs.collapse', function () {
				$(this).prev('.cat-title').find('.icon-down-open-big').removeClass("active-panel");
			})
		} else {
			$('.cat-collapse').removeClass('out').addClass('in').css('height', 'auto');
		}
	});

	// DEMO PREVIEW

	$(".tbtn").click(function () {
		$('.themeControll').toggleClass('active')
	});

	// jobs

	$("input:radio").click(function () {
		if ($('input:radio#job-seeker:checked').length > 0) {
			$('.forJobSeeker').removeClass('hide');
			$('.forJobFinder').addClass('hide');
		} else {
			$('.forJobFinder').removeClass('hide');
			$('.forJobSeeker').addClass('hide')

		}
	});

	$(".filter-toggle").click(function () {
		$('.mobile-filter-sidebar').prepend("<div class='closeFilter'>X</div>");
		$(".mobile-filter-sidebar").animate({"left": "0"}, 250, "linear", function () {
		});
		$('.menu-overly-mask').addClass('is-visible');
	});

	$(".menu-overly-mask").click(function () {
		$(".mobile-filter-sidebar").animate({"left": "-251px"}, 250, "linear", function () {
		});
		$('.menu-overly-mask').removeClass('is-visible');
	});


	$(document).on('click', '.closeFilter', function () {
		$(".mobile-filter-sidebar").animate({"left": "-251px"}, 250, "linear", function () {
		});
		$('.menu-overly-mask').removeClass('is-visible');
	});

});


function listView(selecter) {
	$('.grid-view,.compact-view').removeClass("active");
	$(selecter).addClass("active");
	$('.item-list').addClass("make-list"); //add the class to the clicked element
	$('.item-list').removeClass("make-grid");
	$('.item-list').removeClass("make-compact");
	$('.item-list .add-desc-box').removeClass("col-sm-9");
	$('.item-list .add-desc-box').addClass("col-sm-7");

	$(function () {
		$('.item-list').matchHeight('remove');
	});
}

function gridView(selecter) {
	$('.list-view,.compact-view').removeClass("active");
	$(selecter).addClass("active");
	$('.item-list').addClass("make-grid"); //add the class to the clicked element
	$('.item-list').removeClass("make-list");
	$('.item-list').removeClass("make-compact");
	$('.item-list .add-desc-box').removeClass("col-sm-9");
	$('.item-list .add-desc-box').addClass("col-sm-7");

	$(function () {
		$('.item-list').matchHeight();
		$.fn.matchHeight._apply('.item-list');
	});
}

function compactView(selecter) {
	$('.list-view,.grid-view').removeClass("active");
	$(selecter).addClass("active");
	$('.item-list').addClass("make-compact"); //add the class to the clicked element
	$('.item-list').removeClass("make-list");
	$('.item-list').removeClass("make-grid");
	$('.item-list .add-desc-box').toggleClass("col-sm-9 col-sm-7");

	$(function () {
		$('.adds-wrapper .item-list').matchHeight('remove');
	});
}

/* Set Country Phone Code */
function setCountryPhoneCode(country_code, countries)
{
	if (typeof country_code == "undefined" || typeof countries == "undefined") return false;
	if (typeof countries[country_code] == "undefined") return false;

	$('#phone_country').html(countries[country_code]['phone']);
}

/* Google Maps Generation */
function genGoogleMaps(key, address, language) {
	if (typeof address == "undefined") {
		var q = encodeURIComponent($('#address').text());
	} else {
		var q = encodeURIComponent(address);
	}
	if (typeof language == "undefined") {
		var language = 'en';
	}
	var googleMapsUrl = 'https://www.google.com/maps/embed/v1/place?key=' + key + '&q=' + q + '&language=' + language;

	$('#googleMaps').attr('src', googleMapsUrl);
}

/* Show price & Payment Methods */
function showAmount(packSelected)
{
	var price = $('#price-' + packSelected + ' .priceInt').html();
	price = parseInt(price, 10);
	$('#payableAmount').html(price);
	if (price <= 0) {
		$('#packsTable tbody tr:last').hide();
	} else {
		$('#packsTable tbody tr:last').show();
	}
}

/* JS COOKIE */
/* Create cookie */
function createCookie(name, value, days) {
	var expires;

	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toGMTString();
	} else {
		expires = "";
	}
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}
/* Read cookie */
function readCookie(name) {
	var nameEQ = encodeURIComponent(name) + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
	}
	return null;
}
/* Delete cookie */
function eraseCookie(name) {
	createCookie(name, "", -1);
}
