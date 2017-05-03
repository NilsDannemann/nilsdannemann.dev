<?php
/**
 * Post sharing buttons.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

if ( function_exists( 'sharing_display' ) ) : ?>
	<div class="post-share-buttons">
		<?php sharing_display( '', true ); ?>
	</div>
<?php endif; ?>
