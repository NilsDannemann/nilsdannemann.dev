<?php
/**
 * Template for single post sidebar.
 *
 * @package Stag
 */

if ( ! is_single() ) {
	return;
} elseif ( 0 === (int) stag_theme_mod( 'layout_options', 'post-sidebar' ) ) {
	return;
} elseif ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

?>

<div class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'sidebar-1' ); ?>

</div><!-- #secondary -->
