<?php
/**
 * The sidebar containing the Footer Widget Area 1.
 *
 * @package Stag
 */

/**
 * Filter the sidebar ID to allow developers to programmatically change the sidebar displayed.
 *
 * @since 2.0.0.
 *
 * @param string    $footer_id    The ID of the current footer being generated.
 */
$sidebar_id = apply_filters( 'ink_footer_1', 'sidebar-footer-1' );
$sidebar_id = esc_attr( $sidebar_id );
?>
<section id="footer-1" class="widget-area unit <?php echo $sidebar_id . ' ' . ink_sidebar_class(); ?> <?php echo ( is_active_sidebar( $sidebar_id ) ) ? 'active' : 'inactive'; ?>" role="complementary">
	<?php if ( ! dynamic_sidebar( $sidebar_id ) ) : ?>
		&nbsp;
	<?php endif; ?>
</section>
