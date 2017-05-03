<?php
/**
 * Template for single page sidebar.
 *
 * @package Stag
 */

if ( ! is_page() ) {
	return;
} elseif ( 0 === (int) stag_theme_mod( 'layout_options', 'page-sidebar' ) ) {
	return;
} elseif ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}

?>

<div class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'sidebar-2' ); ?>

</div><!-- #secondary -->
