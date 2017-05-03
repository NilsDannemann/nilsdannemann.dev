<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_page_template( 'widgetized.php' ) ) : ?>
	<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links">',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
