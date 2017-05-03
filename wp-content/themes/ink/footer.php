<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

$sidebar_count = (int) stag_theme_mod( 'stag_footer', 'footer-widget-areas' );

// Test for enabled sidebars that contain widgets.
$has_active_sidebar = false;
if ( $sidebar_count > 0 ) {
	$i = 1;
	while ( $i <= $sidebar_count ) {
		if ( is_active_sidebar( 'sidebar-footer-' . $i ) ) {
			$has_active_sidebar = true;
			break;
		}
		$i++;
	}
}

?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php // Footer widget areas.
			if ( true === $has_active_sidebar ) : ?>
			<div class="footer-widget-container columns-<?php echo esc_attr( $sidebar_count ); ?>">
				<div class="inside">
					<div class="footer-widgets grid">
						<?php
						$current_sidebar = 1;
						while ( $current_sidebar <= $sidebar_count ) :
							get_sidebar( 'footer-' . $current_sidebar );
							$current_sidebar++;
						endwhile; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php $footer_text = stag_theme_mod( 'stag_footer', 'copyright' ); ?>
			<?php if ( ! empty( $footer_text ) || has_nav_menu( 'footer' ) ) : ?>
			<div class="copyright">
				<div class="inside">

					<div class="grid">
						<div class="unit one-of-two site-info">
							<?php echo do_shortcode( stag_allowed_tags( $footer_text ) ); ?>
						</div><!-- .site-info -->

						<?php if ( has_nav_menu( 'footer' ) ) : ?>
						<div class="unit one-of-two">
							<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-menu', 'container' => false, 'fallback_cb' => false, 'before' => '<span class="divider">/</span>' ) ); ?>
						</div>
						<?php endif; ?>
					</div>

				</div>
			</div><!-- .copyright -->
			<?php endif; ?>
		</footer><!-- #colophon -->

	</div><!-- #content -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
