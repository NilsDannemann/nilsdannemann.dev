<?php
/**
 * Contents for single post page.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

$is_sharing_disabled = ! function_exists( 'sharing_display' );

// Hide post navigation.
$hide_navigation = stag_theme_mod( 'post_settings', 'hide_post_navigation' );

if ( $is_sharing_disabled ) {
	$grid_class = 'span-grid';
} else {
	$grid_class = 'one-of-two';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before'      => '<div class="page-links">',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php

	if ( ! $hide_navigation ) :
		ink_post_nav();
	endif;

	?>

	<?php if ( ! stag_rcp_user_has_no_access() ) : ?>
	<footer class="entry-footer">
		<div class="grid">

			<div class="unit <?php echo $grid_class; ?>">
				<?php
					/* translators: used between list items, there is a space after the comma */
					$category_list = get_the_category_list( __( ', ', 'stag' ) );

					/* translators: used between list items, there is a space after the comma */
					$tag_list = get_the_tag_list( '', __( ', ', 'stag' ) );

					$meta_text = '';

					if ( ! stag_categorized_blog() ) {
						// This blog only has 1 category so we just need to worry about tags in the meta text.
						if ( '' !== $tag_list ) {
							$meta_text = __( 'Tags: %2$s', 'stag' );
						}
					} else {
						// But this blog has loads of categories so we should probably display them here.
						if ( '' !== $tag_list ) {
							$meta_text = __( 'Tags: %2$s / Category: %1$s', 'stag' );
						} else {
							$meta_text = __( 'Category: %1$s', 'stag' );
						}
					}

					printf(
						$meta_text,
						$category_list,
						$tag_list
					);
				?>
			</div>

			<?php if ( ! $is_sharing_disabled ) : ?>
			<div class="unit <?php echo $grid_class; ?>">
				<?php get_template_part( '_post', 'share' ); ?>
			</div>
			<?php endif; ?>
		</div>
	</footer><!-- .entry-meta -->
	<?php endif; ?>

</article><!-- #post-## -->
