/**
 * Theme Customizer enhancements for a better user experience.
 */

( function( $ ) {

	wp.customize.bind( 'ready', function() {
		// Only show the 'Number of Related posts to show' control when the checkbox is checked
		wp.customize( 'show_related_posts', function( setting ) {
			console.log(setting.get());
			wp.customize.control( 'related_posts_count', function( control ) {
				var visibility = function() {
					if ( true === setting.get() ) {
						control.container.slideDown( 180 );
					} else {
						control.container.slideUp( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});

		wp.customize( 'show_excerpt', function( setting ) {
			console.log(setting.get());
			wp.customize.control( 'excerpt_length', function( control ) {
				var visibility = function() {
					if ( true === setting.get() ) {
						control.container.slideDown( 180 );
					} else {
						control.container.slideUp( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	});

} )( jQuery );