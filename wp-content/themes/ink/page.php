<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

get_header(); ?>

	<?php get_template_part( '_post', 'cover-wrap' ); ?>

	<main id="main" class="site-main <?php echo esc_attr( ink_single_sidebar_class() ); ?>">

		<div class="page-content-wrapper">

			<div class="content-area">
				<?php
				while ( have_posts() ) :
				the_post();

					get_template_part( 'content', 'page' );

					get_template_part( '_post', 'comments' );

				endwhile; // end of the loop. ?>
			</div>

			<?php get_sidebar( 'page' ); ?>

		</div>

	</main><!-- #main -->

<?php
get_footer();
