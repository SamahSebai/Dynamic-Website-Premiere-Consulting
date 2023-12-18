 AOS.init({
 	duration: 800,
 	easing: 'slide'
 });

(function($) {

	"use strict";

	$(window).stellar({
    responsive: true,
    parallaxBackgrounds: true,
    parallaxElements: true,
    horizontalScrolling: false,
    hideDistantElements: false,
    scrollProperty: 'scroll'
  });


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	// Scrollax
   $.Scrollax();

	var carousel = function() {
		$('.home-slider').owlCarousel({
	    loop:true,
	    autoplay: true,
	    margin:0,
	    animateOut: 'fadeOut',
	    animateIn: 'fadeIn',
	    nav:false,
	    autoplayHoverPause: false,
	    items: 1,
	    navText : ["<span class='ion-md-arrow-back'></span>","<span class='ion-chevron-right'></span>"],
	    responsive:{
	      0:{
	        items:1
	      },
	      600:{
	        items:1
	      },
	      1000:{
	        items:1
	      }
	    }
		});
		$('.carousel-testimony').owlCarousel({
			autoplay: true,
			center: true,
			loop: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 1
				},
				1000:{
					items: 3
				}
			}
		});

	};
	carousel();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  console.log('show');
	});

	// scroll
	var scrollWindow = function() {
		$(window).scroll(function(){
			var $w = $(this),
					st = $w.scrollTop(),
					navbar = $('.ftco_navbar'),
					sd = $('.js-scroll-wrap');

			if (st > 150) {
				if ( !navbar.hasClass('scrolled') ) {
					navbar.addClass('scrolled');	
				}
			} 
			if (st < 150) {
				if ( navbar.hasClass('scrolled') ) {
					navbar.removeClass('scrolled sleep');
				}
			} 
			if ( st > 350 ) {
				if ( !navbar.hasClass('awake') ) {
					navbar.addClass('awake');	
				}
				
				if(sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if ( st < 350 ) {
				if ( navbar.hasClass('awake') ) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if(sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
		});
	};
	scrollWindow();

	
	var counter = function() {
		
		$('#section-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function(){
					var $this = $(this),
						num = $this.data('number');
						console.log(num);
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 7000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();

	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// magnific popup
	$('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    fixedContentPos: true,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
     gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300 // don't foget to change the duration also in CSS
    }
  });

  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,

    fixedContentPos: false
  });


 /* $('.appointment_date').datepicker({
	  'format': 'm/d/yyyy',
	  'autoclose': true
	});

	$('.appointment_time').timepicker();

*/


})(jQuery);
 AOS.init({
	 duration: 800,
	 easing: 'slide',
	 once: true
 });

 jQuery(document).ready(function($) {

	 "use strict";


	 $(".loader").delay(1000).fadeOut("slow");
	 $("#overlayer").delay(1000).fadeOut("slow");


	 var siteMenuClone = function() {

		 $('.js-clone-nav').each(function() {
			 var $this = $(this);
			 $this.clone().attr('class', 'site-nav-wrap').appendTo('.site-mobile-menu-body');
		 });


		 setTimeout(function() {

			 var counter = 0;
			 $('.site-mobile-menu .has-children').each(function(){
				 var $this = $(this);

				 $this.prepend('<span class="arrow-collapse collapsed">');

				 $this.find('.arrow-collapse').attr({
					 'data-toggle' : 'collapse',
					 'data-target' : '#collapseItem' + counter,
				 });

				 $this.find('> ul').attr({
					 'class' : 'collapse',
					 'id' : 'collapseItem' + counter,
				 });

				 counter++;

			 });

		 }, 1000);

		 $('body').on('click', '.arrow-collapse', function(e) {
			 var $this = $(this);
			 if ( $this.closest('li').find('.collapse').hasClass('show') ) {
				 $this.removeClass('active');
			 } else {
				 $this.addClass('active');
			 }
			 e.preventDefault();

		 });

		 $(window).resize(function() {
			 var $this = $(this),
				 w = $this.width();

			 if ( w > 768 ) {
				 if ( $('body').hasClass('offcanvas-menu') ) {
					 $('body').removeClass('offcanvas-menu');
				 }
			 }
		 })

		 $('body').on('click', '.js-menu-toggle', function(e) {
			 var $this = $(this);
			 e.preventDefault();

			 if ( $('body').hasClass('offcanvas-menu') ) {
				 $('body').removeClass('offcanvas-menu');
				 $this.removeClass('active');
			 } else {
				 $('body').addClass('offcanvas-menu');
				 $this.addClass('active');
			 }
		 })

		 // click outisde offcanvas
		 $(document).mouseup(function(e) {
			 var container = $(".site-mobile-menu");
			 if (!container.is(e.target) && container.has(e.target).length === 0) {
				 if ( $('body').hasClass('offcanvas-menu') ) {
					 $('body').removeClass('offcanvas-menu');
				 }
			 }
		 });
	 };
	 siteMenuClone();


	 var sitePlusMinus = function() {
		 $('.js-btn-minus').on('click', function(e){
			 e.preventDefault();
			 if ( $(this).closest('.input-group').find('.form-control').val() != 0  ) {
				 $(this).closest('.input-group').find('.form-control').val(parseInt($(this).closest('.input-group').find('.form-control').val()) - 1);
			 } else {
				 $(this).closest('.input-group').find('.form-control').val(parseInt(0));
			 }
		 });
		 $('.js-btn-plus').on('click', function(e){
			 e.preventDefault();
			 $(this).closest('.input-group').find('.form-control').val(parseInt($(this).closest('.input-group').find('.form-control').val()) + 1);
		 });
	 };
	 // sitePlusMinus();


	 var siteSliderRange = function() {
		 $( "#slider-range" ).slider({
			 range: true,
			 min: 0,
			 max: 500,
			 values: [ 75, 300 ],
			 slide: function( event, ui ) {
				 $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			 }
		 });
		 $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
			 " - $" + $( "#slider-range" ).slider( "values", 1 ) );
	 };
	 // siteSliderRange();



	 var siteCarousel = function () {
		 if ( $('.nonloop-block-13').length > 0 ) {
			 $('.nonloop-block-13').owlCarousel({
				 center: false,
				 items: 1,
				 loop: true,
				 stagePadding: 0,
				 margin: 0,
				 autoplay: true,
				 nav: true,
				 navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
				 responsive:{
					 600:{
						 margin: 0,
						 nav: true,
						 items: 2
					 },
					 1000:{
						 margin: 0,
						 stagePadding: 0,
						 nav: true,
						 items: 3
					 },
					 1200:{
						 margin: 0,
						 stagePadding: 0,
						 nav: true,
						 items: 4
					 }
				 }
			 });
		 }

		 $('.single-text').owlCarousel({
			 center: false,
			 items: 1,
			 loop: true,
			 stagePadding: 0,
			 margin: 0,
			 autoplay: true,
			 pauseOnHover: false,
			 nav: false,
			 smartSpeed: 1000,
		 });
		 $('.slide-one-item').owlCarousel({
			 center: false,
			 items: 1,
			 loop: true,
			 stagePadding: 0,
			 margin: 0,
			 autoplay: true,
			 smartSpeed: 1000,
			 pauseOnHover: false,
			 nav: true,
			 navText: ['<span class="icon-keyboard_arrow_left">', '<span class="icon-keyboard_arrow_right">']
		 });



		 $('.slide-one-item-alt').owlCarousel({
			 center: false,
			 items: 1,
			 loop: true,
			 stagePadding: 0,
			 margin: 0,
			 smartSpeed: 1000,
			 autoplay: true,
			 pauseOnHover: true,
			 mouseDrag: false,
			 touchDrag: false,
		 });
		 $('.slide-one-item-alt-text').owlCarousel({
			 center: false,
			 items: 1,
			 loop: true,
			 stagePadding: 0,
			 margin: 0,
			 smartSpeed: 1000,
			 autoplay: true,
			 pauseOnHover: true,
			 mouseDrag: false,
			 touchDrag: false,

		 });


		 $('.custom-next').click(function(e) {
			 e.preventDefault();
			 $('.slide-one-item-alt').trigger('next.owl.carousel');
			 $('.slide-one-item-alt-text').trigger('next.owl.carousel');
		 });
		 $('.custom-prev').click(function(e) {
			 e.preventDefault();
			 $('.slide-one-item-alt').trigger('prev.owl.carousel');
			 $('.slide-one-item-alt-text').trigger('prev.owl.carousel');
		 });

	 };
	 siteCarousel();

	 var siteStellar = function() {
		 $(window).stellar({
			 responsive: false,
			 parallaxBackgrounds: true,
			 parallaxElements: true,
			 horizontalScrolling: false,
			 hideDistantElements: false,
			 scrollProperty: 'scroll'
		 });
	 };
	 // siteStellar();

	 var siteCountDown = function() {

		 $('#date-countdown').countdown('2020/10/10', function(event) {
			 var $this = $(this).html(event.strftime(''
				 + '<span class="countdown-block"><span class="label">%w</span> weeks </span>'
				 + '<span class="countdown-block"><span class="label">%d</span> days </span>'
				 + '<span class="countdown-block"><span class="label">%H</span> hr </span>'
				 + '<span class="countdown-block"><span class="label">%M</span> min </span>'
				 + '<span class="countdown-block"><span class="label">%S</span> sec</span>'));
		 });

	 };
	 siteCountDown();

	 var siteDatePicker = function() {

		 if ( $('.datepicker').length > 0 ) {
			 $('.datepicker').datepicker();
		 }

	 };
	 siteDatePicker();

	 var siteSticky = function() {
		 $(".js-sticky-header").sticky({topSpacing:0});
	 };
	 siteSticky();

	 // navigation
	 var OnePageNavigation = function() {
		 var navToggler = $('.site-menu-toggle');
		 $("body").on("click", ".main-menu li a[href^='#'], .smoothscroll[href^='#'], .site-mobile-menu .site-nav-wrap li a", function(e) {
			 e.preventDefault();

			 var hash = this.hash;

			 $('html, body').animate({
				 'scrollTop': $(hash).offset().top
			 }, 600, 'easeInOutExpo', function(){
				 window.location.hash = hash;
			 });

		 });
	 };
	 OnePageNavigation();

	 var siteScroll = function() {



		 $(window).scroll(function() {

			 var st = $(this).scrollTop();

			 if (st > 100) {
				 $('.js-sticky-header').addClass('shrink');
			 } else {
				 $('.js-sticky-header').removeClass('shrink');
			 }

		 })

	 };
 })

