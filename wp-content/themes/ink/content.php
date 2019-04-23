<?php
/**
 * @package Stag_Customizer
 * @subpackage Ink
 */

$categories_list = get_the_category_list( ', ' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( '_post', 'background' ); ?>

	<div class="post-content">
		<?php if ( true === stag_theme_mod( 'layout_options', 'hover-effect' ) ) : ?>
		<a href="<?php the_permalink(); ?>" class="post-content-overlay">
			<button><?php echo esc_html( stag_theme_mod( 'layout_options', 'post-grid-hover-text' ) ); ?></button>
		</a>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/layout/grid', 'content' ); ?>
	</div>
</article>
