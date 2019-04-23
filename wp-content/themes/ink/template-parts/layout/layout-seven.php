<?php
/**
 * Template for blog 'Layout: Seven'.
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
		.Grid-background--<?php the_ID(); ?> { background-color: <?php echo stag_maybe_hash_hex_color( $background_color ); // WPCS: XSS ok. ?>;  }

		<?php if ( has_post_thumbnail() ) : ?>
			.Grid-background--<?php the_ID(); ?> .Grid-background__overlay {
				background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'ink-post-cover' ); // WPCS: XSS ok. ?>);
				opacity: <?php echo absint( $background_opacity ) / 100; ?>;
			}
		<?php endif; ?>
	</style>

		<div class="Grid-cell Grid-background Grid-background--<?php the_ID(); ?> stag-image--<?php echo esc_attr( $background_filter ); ?>">
			<div class="Grid-background__overlay"></div>
		</div>

		<div class="Grid-cell Grid-content">
			<div class="Grid-align-center">
				<?php get_template_part( 'template-parts/layout/grid', 'content' ); ?>
			</div>
		</div>
</article>
