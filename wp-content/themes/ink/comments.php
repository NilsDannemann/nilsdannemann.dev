<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to stag_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<div class="cf">
			<h2 class="comments-title">
				<?php
					printf( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'stag' ),
						number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				?>
			</h2>

			<?php $visibility = stag_theme_mod( 'post_settings', 'comments_visibility' ); ?>
			<div class="comment-form-actions">
				<button id="toggle-comment-form" class="button toggle-comments is-<?php echo esc_attr( $visibility ); ?>">
					<span class="show-label"><?php esc_html_e( 'Show', 'stag' ); ?></span>
					<span class="hide-label"><?php esc_html_e( 'Hide', 'stag' ); ?></span>
				</button>
			</div>
		</div>

		<div class="comments-wrap is-<?php echo esc_attr( $visibility ); ?>">
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
				<nav id="comment-nav-above" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'stag' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'stag' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'stag' ) ); ?></div>
				</nav><!-- #comment-nav-above -->
			<?php endif; // Check for comment navigation. ?>

				<ol class="comment-list">
					<?php
						/**
						 * Loop through and list the comments. Tell wp_list_comments()
						 * to use stag_comment() to format the comments.
						 * If you want to overload this in a child theme then you can
						 * define stag_comment() and that will be used instead.
						 * See stag_comment() in inc/template-tags.php for more.
						 */
						wp_list_comments( array( 'callback' => 'stag_comment' ) );
					?>
				</ol><!-- .comment-list -->

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
				<nav id="comment-nav-below" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'stag' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'stag' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'stag' ) ); ?></div>
				</nav><!-- #comment-nav-below -->
			<?php endif; // Check for comment navigation. ?>

			<?php endif; ?>

			<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' !== get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'stag' ); ?></p>
			<?php endif; ?>

			<?php comment_form(); ?>
		</div>

</div><!-- #comments -->
