<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

get_header(); ?>

	<?php get_template_part( '_post', 'cover-wrap' ); ?>

	<main id="main" class="site-main <?php echo esc_attr( ink_single_sidebar_class() ); ?>">

		<div class="post-content-wrapper">

			<div class="content-area">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php

					get_template_part( 'content', 'single' );

					stag_related_posts();

					get_template_part( '_post', 'comments' );

					?>

				<?php endwhile; // end of the loop. ?>
			</div>

		<?php get_sidebar( 'post' ); ?>

		</div>

	</main><!-- #main -->

<?php get_footer();
