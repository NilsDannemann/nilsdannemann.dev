<?php
/**
 * Custom header
 *
 * @package Ink
 */

if ( false === get_header_image() || '' === get_header_image() ) return;

$header_text        = stag_theme_mod( 'header_image', 'header-image-text' );
$header_description = stag_theme_mod( 'header_image', 'header-image-description' );
$header_class       = ( $header_text || $header_description ) ? ' has-header-text' : '';

?>

<section class="custom-header<?php echo esc_attr( $header_class ); ?>" style="background-image:url(<?php echo esc_url( get_header_image() ); ?>);">
	<?php if ( function_exists( 'has_header_video' ) && has_header_video() ) : ?>
		<div class="custom-header-media">
			<?php the_custom_header_markup(); ?>
		</div>
	<?php endif; ?>

	<div class="custom-header-content">

		<div class="custom-header-cover"></div>

		<div class="inner-header-content">
			<?php if ( '' !== $header_text ) : ?>
			<h1 class="custom-header-title"><?php echo $header_text; ?></h1>
			<?php endif; ?>

			<?php if ( '' !== $header_description ) : ?>
			<?php remove_all_filters( 'sharing_display' ); ?>
			<div class="custom-header-description"><?php echo do_shortcode( $header_description ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
