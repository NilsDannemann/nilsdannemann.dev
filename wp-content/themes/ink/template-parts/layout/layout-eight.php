<?php
/**
 * Template for blog 'Layout: Eight'.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 * @since 2.2.0
 */

$categories_list = get_the_category_list( ', ' );

$background_color   = stag_get_post_meta( 'settings', $id, 'post-background-color' );
$background_opacity = stag_get_post_meta( 'settings', $id, 'post-background-opacity' );
$background_filter  = stag_get_post_meta( 'settings', $id, 'post-background-filter' );

// Set a default background opacity.
if ( empty( $background_opacity ) ) {
	$background_opacity = 40;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<style type="text/css">
		.grid-cover--<?php the_ID(); ?> { background-color: <?php echo stag_maybe_hash_hex_color( $background_color ); // WPCS: XSS ok. ?>;  }

		<?php if ( has_post_thumbnail() ) : ?>
			.grid-cover--<?php the_ID(); ?> .grid-cover-image {
				background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'ink-post-cover' ); // WPCS: XSS ok. ?>);
				opacity: <?php echo absint( $background_opacity ) / 100; ?>;
			}
		<?php endif; ?>
	</style>

	<div class="grid-cover grid-cover--<?php the_ID(); ?>">
		<div class="grid-cover-image"></div>
	</div>

	<div class="grid-content">
		<?php get_template_part( 'template-parts/layout/grid', 'content' ); ?>
	</div>
</article>
