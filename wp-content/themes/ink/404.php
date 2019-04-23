<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Ink
 */

get_header();

$error_page_id = stag_theme_mod( '404_page', '404_custom_page' );
$subtitle      = get_post_meta( $post->ID, '_subtitle', true );

if ( false !== (bool) $error_page_id ) :
	$background_filter  = stag_get_post_meta( 'settings', $error_page_id, 'post-background-filter' );
	if ( ! $background_filter ) {
		$background_filter = 'none';
	}

	$post = get_post( $error_page_id );

	?>

		<div id="main" class="site-main page-cover page-cover--<?php echo esc_attr( $post->ID ); ?>">

			<div class="page-cover__background stag-image--<?php echo esc_attr( $background_filter ); ?>"></div>

			<?php stag_post_background_css( $post->ID, '.page-cover--', '.page-cover__background' ); ?>
			<?php $post_class = implode( ' ', get_post_class( 'error-post', $post->ID ) ); ?>
			<article id="post-<?php echo esc_attr( $post->ID ); ?>" class="<?php echo esc_attr( $post_class ); ?>">

				<header class="entry-header">
					<h1 class="entry-title"><?php echo $post->post_title; // WPCS: XSS ok. ?></h1>

					<?php if ( '' !== $subtitle ) : ?>
					<span class="entry-subtitle custom custom-2"><?php echo $subtitle; // WPCS: XSS ok. ?></span>
					<?php endif; ?>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php
					remove_filter( 'the_content', 'sharing_display',19 );
					remove_filter( 'the_excerpt', 'sharing_display',19 );
					echo apply_filters( 'the_content', $post->post_content ); // WPCS: XSS ok.
					?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->

		</div><!-- #main -->

	<?php get_footer(); ?>

<?php else : ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'stag' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'stag' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php
					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'stag' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

endif;

get_footer();
