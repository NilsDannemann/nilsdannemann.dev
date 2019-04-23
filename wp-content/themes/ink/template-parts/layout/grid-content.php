<?php
/**
 * Template partials for grid post content.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 * @since 2.2.0
 */

$categories_list = get_the_category_list( ', ' );

?>

<header class="entry-header">
	<?php
	$premium_text = stag_theme_mod( 'post_settings', 'premium_text' );
	if ( ( stag_is_taxonomy_restricted() || stag_rcp_is_locked() ) && '' !== $premium_text ) :
	?>
		<div class="premium-tag">
			<p><?php echo esc_html( $premium_text ); ?></p>
		</div>
	<?php endif; ?>

	<?php
	$sticky_text = stag_theme_mod( 'post_settings', 'sticky_text' );

	if ( is_sticky() && '' !== $sticky_text ) :
	?>
		<div class="sticky-tag">
			<p><?php echo esc_html( $sticky_text ); ?></p>
		</div>
	<?php endif; ?>

	<h1 class="entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark">
		<?php the_title(); ?>
		<?php if ( has_filter( 'stag_loading_more_posts' ) && function_exists( 'get_the_subtitle' ) && get_the_subtitle() ) : ?>
		<span class="entry-subtitle"><?php echo get_the_subtitle(); // WPCS: XSS ok. ?></span>
		<?php endif; ?>
		</a>
	</h1>
</header><!-- .entry-header -->

<footer class="entry-meta">
	<?php stag_posted_on(); ?>
	<?php edit_post_link( __( 'Edit', 'stag' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-meta -->

<?php if ( stag_theme_mod( 'post_settings', 'post_categories' ) && stag_categorized_blog() && $categories_list ) : ?>
<div class="entry-categories">
	<?php esc_html_e( 'In ', 'stag' ); ?><?php echo $categories_list; // WPCS: XSS Ok. ?>
</div>
<?php endif; ?>

<?php if ( stag_theme_mod( 'post_settings', 'show_excerpt' ) ) : ?>
<div class="post-excerpt">
	<?php the_excerpt(); ?>
</div>
<?php endif; ?>

<?php
/**
 * Show Read more button only for new layouts.
 */
$layout = stag_theme_mod( 'layout_options', 'layout' );
if ( in_array( $layout, array( 'seven', 'eight', 'nine' ), true ) ) :
?>
<a href="<?php the_permalink(); ?>" class="button"><?php echo esc_html( stag_theme_mod( 'layout_options', 'post-grid-hover-text' ) ); ?></a>
<?php endif; ?>
