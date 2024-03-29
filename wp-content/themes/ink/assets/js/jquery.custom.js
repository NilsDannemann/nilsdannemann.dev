/* global postSettings */
/* eslint-disable func-style, vars-on-top */
( function( window, $ ) {
	'use strict';

	// Cache document for fast access.
	var document = window.document;

	var Stag = function() {

		/**
		 * Hold reusable elements.
		 *
		 * @type {Object}
		 */
		var cache = {};

		function init() {

			// Cache the reusable elements
			cacheElements();

			// Bind events
			bindEvents();
		}

		/**
		 * Caches elements that are used in this scope.
		 *
		 * @return void
		 */
		function cacheElements() {
			cache.$window       = $( window );
			cache.$document     = $( document );

			// Test for iPod and Safari
			cache.isiPod        = isiPod();
			cache.isSafari      = isSafari();

			cache.$navToggle    = $( '#site-navigation-toggle' );

			cache.$body         = $( 'body' );
			cache.$isHomepage   = cache.$body.hasClass( 'home' );
			cache.$isSingle     = cache.$body.hasClass( 'single' );
			cache.$isWidgetized = cache.$body.hasClass( 'page-template-widgetized-php' );
			cache.$entryContent = cache.$body.find( '.entry-content' );
			cache.$fullImages   = cache.$entryContent.find( '.full-width' );
			cache.$windowWidth  = cache.$window.width();

			cache.$others       = [];
			cache.$page         = 1;

			cache.windowHeight  = ( true === cache.isiPod && true === cache.isSafari ) ? window.screen.availHeight : cache.$window.height();
		}

		/**
		 * Setup event binding.
		 *
		 * @return void
		 */
		function bindEvents() {

			// Enable the mobile menu
			cache.$document.on( 'ready', function() {
				setupRetinaCookie();
				setupMenu();
				resetHeights();

				setupFullWidthImages();
				RCPStyles();
				removeNoTouchClass();
				runSliderSection();
			});

			cache.$window.on( 'resize', function() {
				setupFullWidthImages();
			});

			var lazyResize = debounce( resetHeights, 200, false );
			cache.$window.resize( lazyResize );

			$( '#scroll-comment-form' ).on( 'click', function( e ) {
				e.preventDefault();
				$( 'html,body' ).animate({
					scrollTop: $( '#respond' ).offset().top
				}, 200 );
			});

			$( '#load-more-posts' ).on( 'click', function( e ) {
				e.preventDefault();
				var data = $( this );
				infinitePosts( data );
			});

			$( '#toggle-comment-form' ).on( 'click', function( e ) {
				e.preventDefault();
				var $this = $( this ),
					openClass = 'is-visible is-collapsed';

				$( '.comments-wrap' ).fadeToggle( 'fast', function() {
					$this.toggleClass( openClass );
				});
			});

			$( '#scroll-to-content' ).on( 'click', function( e ) {
				e.preventDefault();

				$( 'html,body' ).animate({
					scrollTop: $( '#main' ).offset().top - 80
				}, 500, 'linear' );
			});
		}

		/**
		 * Activate the mobile menu.
		 *
		 * @return void
		 */
		function setupMenu( e ) {
			cache.$navToggle.on( 'click', function( e ) {
				e.preventDefault();
				var openClass = 'site-nav-transition site-nav-drawer-open';
				cache.$body.toggleClass( openClass );
			});

			cache.$body.on( 'click', '.site-nav-overlay, .close-nav', function( e ) {
				e.preventDefault();
				var openClass = 'site-nav-transition site-nav-drawer-open';
				cache.$body.toggleClass( openClass );
			});
		}

		function resetHeights() {
			setDivHeight( '.article-cover:not(.page-cover)', cache.$others );

			if ( 800 > cache.$window.width() ) {
				$( '.Grid-background, .grid-cover' ).css( 'height', cache.$window.width() / 1.7 );
			}
		}

		function setupFullWidthImages() {
			var $singleSidebarOn = false;

			if ( 0 < cache.$body.find( '.single-sidebar-on' ).length ) {
				$singleSidebarOn = true;
			}

			cache.$fullImages.each( function() {
				var _this = $( this );

				/**
				 * Remove attribute 'srcset' in so full width images can take the maximum width available.
				 *
				 * @since 2.2.4
				 */
				_this.removeAttr( 'srcset' );

				if ( false === $singleSidebarOn ) {
					if ( _this.hasClass( 'wp-caption' ) ) {
						_this.css({ 'margin-left': ( ( cache.$entryContent.width() / 2 ) - ( cache.$window.width() / 2 ) ), 'max-width': 'none' });
						_this.add( _this.find( 'img' ) ).css( 'width', cache.$window.width() );
					} else {
						_this.css({ 'margin-left': ( ( cache.$entryContent.width() / 2 ) - ( cache.$window.width() / 2 ) ), 'max-width': 'none', 'width': cache.$window.width() });
					}
				}

			});
		}

		function infinitePosts( el ) {
			el.parent().addClass( 'loading' );

			el.spin( 'medium', '#000' );

			cache.$page++;

			var jqxhr = $.post( postSettings.ajaxurl, {
				action: 'stag_inifinite_scroll',
				nonce: postSettings.nonce,
				search: postSettings.search,
				archive: el.data( 'archive' ),
				page: cache.$page
			}, function( data ) {

				// Remove load more button if no pages are left
				if ( cache.$page >= data.pages ) {
el.parent().fadeOut();
}

				//Append the content
				$( '#main' ).append( data.content );
			}, 'json' );

			jqxhr.done( function() {
				el.parent().removeClass( 'loading' );
				el.spin( false );
			});
		}

		/**
		 * Set 'retina' cookie if on a retina device.
		 *
		 * @return void
		 */
		function setupRetinaCookie() {
			if ( -1 === document.cookie.indexOf( 'retina' ) && 'devicePixelRatio' in window && 2 === window.devicePixelRatio ) {
				document.cookie = 'retina=' + window.devicePixelRatio + ';';
			}
		}

		/**
		 * Check if device is an iPhone or iPod
		 *
		 * @returns {boolean}
		 */
		function isiPod() {
			return ( /(iPhone|iPod)/g ).test( navigator.userAgent );
		}

		/**
		 * Check if browser is Safari
		 *
		 * @returns {boolean}
		 */
		function isSafari() {
			return ( -1 !== navigator.userAgent.indexOf( 'Safari' ) && -1 === navigator.userAgent.indexOf( 'Chrome' ) );
		}

		/**
		 * Calculate and set the new height of an element
		 *
		 * @param string element   The div to set the height on
		 * @param array  others    An array of other elements to use to calculate the new height
		 *
		 * @return void
		 */
		function setDivHeight( element, others ) {

			// iOS devices return an incorrect value with height() so availHeight is used instead.
			var windowHeight = ( true === cache.isiPod && true === cache.isSafari ) ? window.screen.availHeight : cache.$window.height();
			var offsetHeight = 0;

			// Add up the heights of other elements
			for ( var i = 0; i < others.length; i++ ) {
				offsetHeight += $( others[i]).outerHeight();
			}

			var newHeight = windowHeight - offsetHeight - parseInt( $( 'html' ).css( 'margin-top' ) );

			if ( cache.$body.hasClass( 'traditional-navigation' ) || cache.$body.hasClass( 'header-normal' ) ) {
				newHeight = newHeight - $( '.site-header' ).outerHeight();
			}

			// Only set the height if the new height is greater than the original
			if ( 0 < newHeight ) {
				$( element ).outerHeight( newHeight );
			}
		}

		/**
		 * Throttles an action.
		 *
		 * Taken from Underscore.js.
		 *
		 * @link    http://underscorejs.org/#debounce
		 *
		 * @param   func
		 * @param   wait
		 * @param   immediate
		 * @returns {Function}
		 */
		function debounce( func, wait, immediate ) {
			var timeout, args, context, timestamp, result;
			return function() {
				context = this;
				args = arguments;
				timestamp = new Date();
				var later = function() {
					var last = ( new Date() ) - timestamp;
					if ( last < wait ) {
						timeout = setTimeout( later, wait - last );
					} else {
						timeout = null;
						if ( ! immediate ) {
							result = func.apply( context, args );
						}
					}
				};
				var callNow = immediate && ! timeout;
				if ( ! timeout ) {
					timeout = setTimeout( later, wait );
				}
				if ( callNow ) {
					result = func.apply( context, args );
				}
				return result;
			};
		}

		function RCPStyles() {

			var $rcpForm = $( '.rcp_form' );
            var $gateway = $rcpForm.find( '#rcp_gateway' );

			$( '.rcp_form #rcp_subscription_levels li:first-child' ).addClass( 'checked' );
			$( '.rcp_form #rcp_subscription_levels input:radio' ).on( 'click', function() {
				$( '.rcp_form #rcp_subscription_levels li' ).removeClass( 'checked' ),
				$( this ).parent().addClass( 'checked' );
			});

			// check if payment gateway dropdown exist.
			if ( $gateway.length ) {
				$rcpForm.find( '#rcp_auto_renew_wrap' ).addClass( 'adjust-padding' );
			}

		}

		// Touch Device Detection
		function removeNoTouchClass() {
			var isTouchDevice = 'ontouchstart' in document.documentElement;
			if ( isTouchDevice ) {
				$( 'body' ).removeClass( 'no-touch' );
			}
		}

		// Run Slider
		function runSliderSection() {
			$( '.page-template-widgetized' ).find( '.stag_widget_feature_slides' ).each( function() {
				var _this = $( this ),
					flexTransition = _this.find( '.featured-slides' ).data( 'transition' ),
					flexSpeed = _this.find( '.featured-slides' ).data( 'speed' ),
					flexPause = _this.find( '.featured-slides' ).data( 'pause' ),
					pagination = _this.find( '.featured-slides' ).data( 'pagination' ),
					paginate = false,
					dataPause = false,
					navContainer = _this.find( '.control-nav-container' );

				if ( 1 === flexPause ) {
					dataPause = true;
				}
				if ( 1 === pagination ) {
					paginate = true;
				}

				if ( 'undefined' !== typeof( $.fn.flexslider ) ) {
					$( '.site-slider' ).flexslider({
						animation: flexTransition,
						controlNav: paginate,
						controlsContainer: navContainer,
						directionNav: false,
						slideshow: true,
						slideshowSpeed: flexSpeed * 1000, // in milliseconds
						animationSpeed: 600,
						pauseOnHover: dataPause,
						smoothHeight: true,
						start: function() {
							$( '.site-slider' ).removeClass( 'loading' );
						}
					});
				}
			});
		}

		// Initiate the actions.
		init();
	};

	// Instantiate the "class".
	window.Stag = new Stag();
}( window, jQuery ) );
