<?php
/**
 * Archive page title layout.
 *
 * @package Ink
 * @since 2.0.0.
 */

?>

<?php if ( ! is_author() && ( is_archive() || is_search() ) ) : ?>
<div class="archive-header-wrapper">
	<div class="inside">
		<div class="archive-header">
			<h3 class="archive-header__title">
				<span class="term"><?php echo stag_archive_title(); ?></span>
			</h3>
		</div>
	</div>
</div>
<?php endif; ?>
