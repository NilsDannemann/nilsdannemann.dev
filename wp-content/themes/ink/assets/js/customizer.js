/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Accent color
	wp.customize( 'accent', function( value ) {
		value.bind( function( to ) {
			$( '.accent-background, .stag-button.instagram-follow-link, button, .button, input[type="reset"], input[type="submit"], input[type="button"], .search-submit' ).css( 'background-color', to);
			$( 'a' ).css( 'border-color', to );
		} );
	} );

	// Background Color
	wp.customize( 'background', function( value ) {
		value.bind( function( to ) {
			$( 'body, #page' ).css( 'background-color', to );
		} );
	} );

	// Footer copyright text
	wp.customize( 'copyright', function( value ) {
		value.bind( function( to ) {
			$( '.site-info' ).html( to );
		} );
	} );

	wp.customize( 'premium_text', function( value ) {
		value.bind( function( to ) {
			$( '.premium-tag p' ).text( to );
		} );
	} );

	wp.customize( 'sticky_text', function( value ) {
		value.bind( function( to ) {
			$( '.sticky-tag p' ).text( to );
		} );
	} );

	// Toggle Author title visibility
	wp.customize( 'hide_author_title', function( value ) {
		value.bind( function( to ) {
			if( to === true ) {
				$('.byline').hide();
			}else if( to === false ) {
				$('.byline').show();
			}
		} );
	} );

	// Toggle Post Reading time
	wp.customize( 'hide_reading_time', function( value ) {
		value.bind( function( to ) {
			if( to === true ) {
				$('.reading-time').hide();
			}else if( to === false ) {
				$('.reading-time').show();
			}
		} );
	} );

	// Header Image Text
	wp.customize( 'header-image-text', function( value ) {
		value.bind( function( to ) {
			$( '.custom-header-title' ).text( to );
		} );
	} );

	// Header Image Description
	wp.customize( 'header-image-description', function( value ) {
		value.bind( function( to ) {
			$( '.custom-header-description' ).html( to );
		} );
	} );

	// Header Image Cover Color
	wp.customize( 'header-image-cover', function( value ) {
		value.bind( function( to ) {
			$( '.custom-header-cover' ).css( 'background-color', to );
		} );
	} );

	// Header Image Cover Opacity
	wp.customize( 'header-image-opacity', function( value ) {
		value.bind( function( to ) {
			$('.custom-header-cover').css('opacity', ( 100 - to ) / 100 );
		} );
	} );

} )( jQuery );
