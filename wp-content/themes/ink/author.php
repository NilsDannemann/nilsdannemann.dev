<?php
/**
 * Author page template.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

// Current author.
global $authordata;

if ( is_object( $authordata ) ) {
	$author_id = $authordata->ID;
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( have_posts() ) : ?>
				<section class="page-header current-author">
					<div class="page-header__content">
						<div class="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'email' ), 105 ); ?>
						</div>

						<h1 class="current-author__name"><?php echo esc_attr( get_the_author_meta( 'display_name' ) ); ?></h1>

						<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="current-author__description"><?php echo wpautop( get_the_author_meta( 'description' ) ); ?></div>
						<?php endif; ?>

						<div class="current-author__social-profiles">
							<?php
							$social_profiles = stag_get_user_social_profiles( get_the_author_meta( 'ID' ) );
							$default_fields = stag_custom_user_fields();

							if ( count( $social_profiles ) ) {
								foreach ( $social_profiles as $slug => $url ) {
									echo '<li class="' . esc_attr( $slug ) . '"><a href="' . esc_url( $url ) . '" title="' . esc_attr( ucfirst( $slug ) ) . '"><i class="fa ' . $default_fields[ $slug ]['class'] . '"></i></a></li>';
								}
							}

							if ( '' !== $author_url = get_the_author_meta( 'user_url' ) ) {
								echo '<li class="website"><a href="' . esc_url( $author_url ) . '" title="' . esc_attr__( 'Website', 'stag' ) . '"><i class="fa fa-globe"></i></a></li>';
							}
							?>
						</div>
					</div><!-- .page-header__content -->
				</section><!-- .page-header -->

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/**
						 * Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->

		<?php get_template_part( '_post', 'load' ); ?>

	</div><!-- #primary -->

<?php get_footer();
