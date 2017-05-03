<?php
/**
 * Restrict Content Pro related functions.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 *
 * @since 1.0
 */

/**
 * Checks if Restrict Content Pro is active.
 *
 * @return bool
 */
function stag_is_rcp_active() {
	if ( defined( 'RCP_PLUGIN_VERSION' ) ) {
		return true;
	}
	return false;
}
add_action( 'admin_init', 'stag_is_rcp_active' );

/**
 * Check if current post is locked.
 *
 * @return bool
 */
function stag_rcp_is_locked() {

	if ( ! stag_is_rcp_active() ) return false;

	global $post, $rcp_options;

	if ( rcp_is_paid_content( $post->ID ) ) {
		return true;
	}

	return false;
}

/**
 * Check if current post has restricted taxonomy.
 *
 * Modified from: rcp_filter_restricted_category_content()
 *
 * @since 2.1.0.
 * @return bool true if tax is restricted, false if unrestricted
 */
function stag_is_taxonomy_restricted() {

	if ( ! stag_is_rcp_active() ) return false;

	global $post, $rcp_options;

	$restrictions = array();

	foreach ( rcp_get_restricted_taxonomies() as $taxonomy ) {
		$restriction = stag_is_post_taxonomy_restricted( $post->ID, $taxonomy );
		if ( true === $restriction ) {
			break;
		}
	}

	return $restriction;
}

/**
 * Check the provided taxonomy along with the given post id to see if any restrictions are found
 *
 * Modified from: rcp_is_post_taxonomy_restricted()
 *
 * @since 2.1.0.
 * @return bool true if tax is restricted, false if unrestricted
 */
function stag_is_post_taxonomy_restricted( $post_id, $taxonomy ) {

	$restricted = false;

	// make sure this post supports the supplied taxonomy.
	$post_taxonomies = get_post_taxonomies( $post_id );
	if ( ! in_array( $taxonomy, (array) $post_taxonomies ) ) {
		return $restricted;
	}

	$terms = get_the_terms( $post_id, $taxonomy );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return $restricted;
	}

	// Loop through the categories and determine if one has restriction options.
	foreach ( $terms as $term ) {

		$term_meta = rcp_get_term_restrictions( $term->term_id );

		if ( empty( $term_meta['paid_only'] ) && empty( $term_meta['subscriptions'] ) && ( empty( $term_meta['access_level'] ) || 'None' == $term_meta['access_level'] ) ) {
			continue;
		}

		$restricted = false;

		/* Check that the user has a paid subscription */
		$paid_only = ! empty( $term_meta['paid_only'] );
		if ( $paid_only ) {
			$restricted = true;
		}

		/* If restricted to one or more subscription levels */
		$subscriptions = ! empty( $term_meta['subscriptions'] );
		if ( $subscriptions ) {
			$restricted = true;
		}

		/* If restricted to one or more access levels */
		$access_level = ! empty( $term_meta['access_level'] ) ? absint( $term_meta['access_level'] ) : 0;
		if ( 0 !== $paid_only ) {
			$restricted = true;
		}

		// if we are matching all terms then it only takes one restricted term to restrict the taxonomy.
		if ( true == $restricted ) {
			break;
		}
	}

	return $restricted;
}

/**
 * Check if current post is locked and if user has access to current content.
 *
 * @return bool
 */
function stag_rcp_user_has_no_access() {

	if ( ! stag_is_rcp_active() ) return false;

	global $post, $user_ID, $rcp_options;
	$access_level = get_post_meta( $post->ID, 'rcp_access_level', true );

	if ( rcp_is_paid_content( $post->ID ) ) {
		if ( ! rcp_is_paid_user( $user_ID ) || ( ! rcp_user_has_access( $user_ID, $access_level ) && $access_level > 0 ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Display Subscribe/Login button on restricted pages.
 *
 * @return void
 */
function stag_rcp_locked_options( $atts ) {
	if ( ! stag_is_rcp_active() ) return;

	$args = shortcode_atts( array(
		'button' => '',
	), $atts, 'locked_options' );

	global $user_ID, $rcp_options;

	$is_displayed      = $show_login_button = false;
	$registration_page = $rcp_options['registration_page'];

	if ( ! is_user_logged_in() ) {
		$show_login_button = true;
	}

	$has_access       = ( ! rcp_is_paid_user( $user_ID ) && isset( $registration_page ) && $registration_page != '' ) ? true : false;

	if ( isset( $args['button'] ) && $args['button'] != '' ) {
		$button_color = $args['button'];
	} else {
		$background_color = stag_get_post_meta( 'settings', get_the_ID(), 'post-background-color' );
		$button_color     = ( $background_color === '' && ! has_post_thumbnail() ) ? 'black' : 'white';

		if ( is_single() ) $button_color = 'black';
	}

	ob_start();

	?>

	<div class="locked-options<?php echo ( $has_access ) ? ' no-access' : ' has-access'; ?> <?php echo $button_color ?>-buttons">
		<?php if ( $has_access ) : ?>
			<a href="<?php echo get_permalink( $registration_page ); ?>" class="stag-button stag-button--normal stag-button--<?php echo esc_attr( $button_color ); ?>"><?php _e( 'Subscribe', 'stag' ); ?></a>
			<?php $is_displayed = true; ?>
		<?php endif; ?>
		<?php if ( $show_login_button ) : ?>
			<a href="<?php echo wp_login_url(); ?>" class="stag-button stag-button--normal stag-button--<?php echo esc_attr( $button_color ); ?>"><?php _e( 'Login', 'stag' ); ?></a>
		<?php endif; ?>
	</div>

	<?php

	return ob_get_clean();
}
add_shortcode( 'locked_options', 'stag_rcp_locked_options' );

function stag_rcp_error_before() {
	echo '<div class="stag-alert stag-alert--red">';
}
add_action( 'rcp_error_before', 'stag_rcp_error_before', 1 );

function stag_rcp_error_after() {
	echo '</div>';
}
add_action( 'rcp_error_after', 'stag_rcp_error_after', 1 );

function stag_rcp_registration_title() {
	return _e( 'Don&rsquo;t have an account? Subscribe here!', 'stag' );
}
add_filter( 'rcp_registration_header_logged_in', 'stag_rcp_registration_title' );
