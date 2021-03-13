/* global zubinOptions */
 /*
 * Custom scripts
 * Description: Custom scripts for zubin
 */

( function( $ ) {

	jQuery( document ).ready( function() {
		jQuery( window ).on( 'load.zubin resize.zubin', function() {
			jQuery('.menu-wrapper .menu-inside-wrapper').on('focusout', function () {
				var $elem = jQuery(this);
				
				// let the browser set focus on the newly clicked elem before check
			    setTimeout(function () {
			        if ( ! $elem.find(':focus').length ) {
			            $elem.parent().find( '.menu-toggle' ).trigger('click');
			        }
			    }, 0);
			});
		} );
	});

	// Owl Carousel
	if ( $.isFunction( $.fn.owlCarousel ) ) {
		// Featured Slider
		var sliderOptions = {
			rtl:zubinOptions.rtl ? true : false,
			autoHeight:true,
			margin: 0,
			items: 1,
			autoplayHoverPause: true,
			nav: true,
			dots: true,
			autoplay: true,
			autoplayTimeout: 4000,
			loop: true,
			dotsContainer: '#slider-dots',
			navContainer: '#slider-nav'
		};

		$(".main-slider").owlCarousel(sliderOptions);

		// Testimonial Section
		var testimonialOptions = {
			rtl:zubinOptions.rtl ? true : false,
			autoHeight: true,
			margin: 0,
			items: 1,
			autoplayHoverPause: true,
			nav: true,
			dots: false,
			autoplay: true,
			autoplayTimeout: 4000,
			loop: false,
			rewind: true,
			responsive: {
				0:{
					items:1
				}
			}
		};

		$( '.testimonial-slider' ).owlCarousel(testimonialOptions);


		// Why Choose Us section
		var whychooseusOptions = {
			rtl:zubinOptions.rtl ? true : false,
			autoHeight:true,
			margin: 0,
			items: 1,
			autoplayHoverPause: true,
			nav: true,
			dots: true,
			autoplay: true,
			autoplayTimeout: 4000,
			loop: true,
			center: true,
			margin:0,
			responsive:{
				0:{
					items:2
				},
			},
			dotsContainer: '#why-choose-us-dots'
		};

		$(".who-choose-us-slider").owlCarousel(whychooseusOptions);

	}

	// Match Height of Featured Content
	if ( $.isFunction( $.fn.matchHeight ) ) {
		$('.logo-slider-section.style2 .hentry, .testimonial-content-section.style1 .hentry-inner, .testimonial-content-section.style4 .hentry-inner, .testimonial-content-section.style2 .entry-content, .testimonial-content-section.style2 .entry-summary, .pricing-section .hentry-inner, .events-section.grid-layout .entry-container, .contact-section .contact-info .hentry-inner').matchHeight();
	}


	$( function() {

		//Adding padding top for header to match with custom header
		$( window ).on( 'load.zubin resize.zubin', function () {
			if ( $( 'body' ).hasClass( 'has-custom-header' ) || $( 'body' ).hasClass( 'absolute-header' )) {
				headerheight = $('#masthead').height();
				$('.custom-header').css('padding-top', headerheight );
			}
		});

	});

	// Add header video class after the video is loaded.
	$( document ).on( 'wp-custom-header-video-loaded', function() {
		$( 'body' ).addClass( 'has-header-video' );
	});

	/*
	 * Test if inline SVGs are supported.
	 * @link https://github.com/Modernizr/Modernizr/
	 */
	function supportsInlineSVG() {
		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
	}

	$( function() {
		$( document ).ready( function() {
			if ( true === supportsInlineSVG() ) {
				document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
			}
		});
	});

	/* Menu */
	var body, masthead, menuToggle, siteNavigation, socialNavigation, siteHeaderMenu, resizeTimer;

	function initMainNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
			.append( $( '<span />', { 'class': 'screen-reader-text', text: zubinOptions.screenReaderText.expand }) );

		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

		// Toggle buttons and submenu items with active children menu items.
		container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

		// Add menu items with submenus to aria-haspopup="true".
		container.find( '.menu-item-has-children, .page_item_has_children' ).attr( 'aria-haspopup', 'true' );

		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this            = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );

			// jscs:disable
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
			screenReaderSpan.text( screenReaderSpan.text() === zubinOptions.screenReaderText.expand ? zubinOptions.screenReaderText.collapse : zubinOptions.screenReaderText.expand );
		} );
	}

	initMainNavigation( $( '.main-navigation, .top-navigation, .secondary-navigation' ) );

	masthead         = $( '#masthead, #site-secondary-header-menu' );
	menuToggle       = masthead.find( '.menu-toggle' );
	siteHeaderMenu   = masthead.find( '#site-header-menu' );
	siteNavigation   = masthead.find( '#site-navigation' );
	socialNavigation = masthead.find( '#social-navigation' );


	// Enable menuToggle.
	( function() {

		// Adds our overlay div.
		$( '.below-site-header' ).prepend( '<div class="overlay">' );

		// Assume the initial scroll position is 0.
		var scroll = 0;

		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}

		menuToggle.on( 'click.zubin', function() {
			// jscs:disable
			$( this ).add( siteNavigation ).attr( 'aria-expanded', $( this ).add( siteNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
		} );


		// Add an initial values for the attribute.
		menuToggle.add( siteNavigation ).attr( 'aria-expanded', 'false' );
		menuToggle.add( socialNavigation ).attr( 'aria-expanded', 'false' );

		// Wait for a click on one of our menu toggles.
		menuToggle.on( 'click.zubin', function() {

			// Assign this (the button that was clicked) to a variable.
			var button = this;

			// Gets the actual menu (parent of the button that was clicked).
			var menu = $( this ).parents( '.menu-wrapper' );

			// Remove selected classes from other menus.
			$( '.menu-toggle' ).not( button ).removeClass( 'selected' );
			$( '.menu-wrapper' ).not( menu ).removeClass( 'is-open' );

			// Toggle the selected classes for this menu.
			$( button ).toggleClass( 'selected' );
			$( menu ).toggleClass( 'is-open' );

			// Is the menu in an open state?
			var is_open = $( menu ).hasClass( 'is-open' );

			// If the menu is open and there wasn't a menu already open when clicking.
			if ( is_open && ! jQuery( 'body' ).hasClass( 'menu-open' ) ) {

				// Get the scroll position if we don't have one.
				if ( 0 === scroll ) {
					scroll = $( 'body' ).scrollTop();
				}

				// Add a custom body class.
				$( 'body' ).addClass( 'menu-open' );

			// If we're closing the menu.
			} else if ( ! is_open ) {

				$( 'body' ).removeClass( 'menu-open' );
				$( 'body' ).scrollTop( scroll );
				scroll = 0;
			}
		} );

		// Close menus when somewhere else in the document is clicked.
		$( document ).on( 'click touchstart', function() {
			$( 'body' ).removeClass( 'menu-open' );
			$( '.menu-toggle' ).removeClass( 'selected' );
			$( '.menu-wrapper' ).removeClass( 'is-open' );
		} );

		// Stop propagation if clicking inside of our main menu.
		$( '.site-header-menu, .menu-toggle, .dropdown-toggle, .search-field, #site-navigation, #social-search-wrapper, #social-navigation .search-submit' ).on( 'click touchstart', function( e ) {
			e.stopPropagation();
		} );
	} )();

	//For Footer Menu
	menuToggleFooter       = $( '#menu-toggle-footer' ); // button id
	siteFooterMenu         = $( '#footer-menu-wrapper' ); // wrapper id
	siteNavigationFooter   = $( '#site-footer-navigation' ); // nav id
	initMainNavigation( siteNavigationFooter );

	// Enable menuToggleFooter.
	( function() {
		// Return early if menuToggleFooter is missing.
		if ( ! menuToggleFooter.length ) {
			return;
		}

		// Add an initial values for the attribute.
		menuToggleFooter.add( siteNavigationFooter ).attr( 'aria-expanded', 'false' );

		menuToggleFooter.on( 'click', function() {
			$( this ).add( siteFooterMenu ).toggleClass( 'toggled-on selected' );

			// jscs:disable
			$( this ).add( siteNavigationFooter ).attr( 'aria-expanded', $( this ).add( siteNavigationFooter ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
		} );
	} )();

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	( function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( window.innerWidth >= 910 ) {
				$( document.body ).on( 'touchstart.zubin', function( e ) {
					if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
						$( '.main-navigation li' ).removeClass( 'focus' );
					}
				} );
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).on( 'touchstart.zubin', function( e ) {
					var el = $( this ).parent( 'li' );

					if ( ! el.hasClass( 'focus' ) ) {
						e.preventDefault();
						el.toggleClass( 'focus' );
						el.siblings( '.focus' ).removeClass( 'focus' );
					}
				} );
			} else {
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.zubin' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.zubin', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		siteNavigation.find( 'a' ).on( 'focus.zubin blur.zubin', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		} );

		$('.main-navigation button.dropdown-toggle, .top-navigation button.dropdown-toggle, .secondary-navigation button.dropdown-toggle').click(function() {
			$(this).toggleClass('active');
			$(this).parent().find('.children, .sub-menu').first().toggleClass('toggled-on');
		});
	} )();

	// Add the default ARIA attributes for the menu toggle and the navigations.
	function onResizeARIA() {
		if ( window.innerWidth < 910 ) {
			if ( menuToggle.hasClass( 'toggled-on' ) ) {
				menuToggle.attr( 'aria-expanded', 'true' );
			} else {
				menuToggle.attr( 'aria-expanded', 'false' );
			}

			if ( siteHeaderMenu.hasClass( 'toggled-on' ) ) {
				siteNavigation.attr( 'aria-expanded', 'true' );
				socialNavigation.attr( 'aria-expanded', 'true' );
			} else {
				siteNavigation.attr( 'aria-expanded', 'false' );
				socialNavigation.attr( 'aria-expanded', 'false' );
			}

			menuToggle.attr( 'aria-controls', 'site-navigation social-navigation' );
		} else {
			menuToggle.removeAttr( 'aria-expanded' );
			siteNavigation.removeAttr( 'aria-expanded' );
			socialNavigation.removeAttr( 'aria-expanded' );
			menuToggle.removeAttr( 'aria-controls' );
		}
	}

	$(document).ready(function() {
		/*Search and Social Container*/
		$('.toggle-top').on('click', function(e){
			$(this).toggleClass('toggled-on');
		});

		$('#search-toggle').on('click', function(){
			$('#header-menu-social, #share-toggle').removeClass('toggled-on');
			$('#header-search-container').toggleClass('toggled-on');
		});

		$('#share-toggle').on('click', function(e){
			e.stopPropagation();
			$('#header-search-container, #search-toggle').removeClass('toggled-on');
			$('#header-menu-social').toggleClass('toggled-on');
		});
	});

    //Masonry blocks
    $blocks = $('#infinite-post-wrap, .grid');

    $blocks.imagesLoaded(function(){
    	$blocks.masonry({
    		itemSelector: '.grid-item',
    		columnWidth: '.grid-item',
    		// slow transitions
    		transitionDuration: '1s',
    		percentPosition: true
    	});

    	// Fade blocks in after images are ready (prevents jumping and re-rendering)
    	$('.grid-item').fadeIn();
    	$blocks.find( '.grid-item' ).animate( {
    		'opacity' : 1
    	} );

    });

    $(document).ready( function() { setTimeout( function() { $blocks.masonry(); }, 2000); });

    $(window).resize(function () {
    	$blocks.masonry();
    });

    // When Jetpack Infinite scroll posts have loaded
    $( document.body ).on( 'post-load', function () {
    	var $container = $('#infinite-post-wrap, #project-masonry');
    	$container.masonry( 'reloadItems' );

    	$blocks.imagesLoaded(function(){
    		$blocks.masonry({
    			itemSelector: '.grid-item',
    			// slow transitions
    			transitionDuration: '1s',
    			percentPosition: true
    		});

    		// Fade blocks in after images are ready (prevents jumping and re-rendering)
    		$('.grid-item').fadeIn();
    		$blocks.find( '.grid-item' ).animate( {
    			'opacity' : 1
    		} );

    	});
    	$(document).ready( function() { setTimeout( function() { $blocks.masonry(); }, 2000); });
    });


    /*Click and scrolldown from custom header and silder*/
    $('body').on('click touch','.scroll-down', function(e){
    	e.preventDefault();
        var Sclass = $(this).parents('.section, .custom-header').next().attr('class');
        var Sclass_array = Sclass.split(" ");
        var scrollto = $('.' + Sclass_array[0] ).offset().top;

        $('html, body').animate({
            scrollTop: scrollto
        }, 1000);

    });

    /* Support for Zubin Music Child theme Sticky Playlist */
    /* Playlist On Scroll For Mobile */
	var PlaylistOnScroll = function(){

		var scrollTop = $(window).scrollTop();

		if (scrollTop > 46) {
			$('body').addClass('playlist-fixed');
		} else {
			$('body').removeClass('playlist-fixed');
		}
	};

	/*Onload*/
	PlaylistOnScroll();

	/*On Scroll*/
	$(window).scroll(function() {
		PlaylistOnScroll();
	});

	$(function(){
        $('.playlist-wrapper .hentry').append('<button class="playlist-hide"><span class="fa fa-angle-left" aria-hidden="true"></span></button>');
        $('.playlist-hide').on('click', function(){
            $(this).parents('.section').toggleClass('playlist-shorten');
            $('body').toggleClass('playlist-made-short');
        });
    });
    /* Support for Zubin Music Child theme Sticky Playlist End */
} )( jQuery );
