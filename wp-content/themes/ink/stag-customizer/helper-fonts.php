<?php
/**
 * Helpers functions for Google Fonts.
 *
 * @package Stag_Customizer
 *
 * @since  1.0.1.
 */

if ( ! function_exists( 'stag_get_font_stack' ) ) :
/**
 * Validate the font choice and get a font stack for it.
 *
 * @since  1.0.0.
 *
 * @param  string $font    The 1st font in the stack.
 * @return string          The full font stack.
 */
function stag_get_font_stack( $font ) {
	$all_fonts = stag_get_all_fonts();

	// Sanitize font choice.
	$font = stag_sanitize_font_choice( $font );

	// Standard font.
	if ( isset( $all_fonts[ $font ]['stack'] ) && ! empty( $all_fonts[ $font ]['stack'] ) ) {
		$stack = $all_fonts[ $font ]['stack'];
	} elseif ( in_array( $font, stag_all_font_choices(), true ) ) {
		$stack = '"' . $font . '","Helvetica Neue",Helvetica,Arial,sans-serif';
	} else {
		$stack = '"Helvetica Neue",Helvetica,Arial,sans-serif';
	}

	return $stack;
}
endif;

if ( ! function_exists( 'stag_get_google_font_uri' ) ) :
/**
 * Build the HTTP request URL for Google Fonts.
 *
 * @since  1.0.0.
 *
 * @return string    The URL for including Google Fonts.
 */
function stag_get_google_font_uri() {
	// Grab the font choices.
	$fonts = apply_filters( 'stag_google_font_choices', array(
		stag_theme_mod( 'typography', 'body_font' ),
		stag_theme_mod( 'typography', 'header_font' ),
	) );

	// De-dupe the fonts.
	$fonts         = array_unique( $fonts );
	$allowed_fonts = stag_get_google_fonts();
	$family        = array();

	// Validate each font and convert to URL format.
	foreach ( $fonts as $font ) {
		$font = trim( $font );

		// Verify that the font exists.
		if ( array_key_exists( $font, $allowed_fonts ) ) {
			// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700").
			$family[] = urlencode( $font ) . ':' . join( ',', stag_choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) );
		}
	}

	// Convert from array to string.
	if ( empty( $family ) ) {
		return '';
	} else {
		$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
	}

	// Load the font subset.
	$subset = stag_theme_mod( 'typography', 'subset' );

	if ( 'all' === $subset ) {
		$subsets_available = stag_get_google_font_subsets();

		// Remove the all set.
		unset( $subsets_available['all'] );

		// Build the array.
		$subsets = array_keys( $subsets_available );
	} else {
		$subsets = array(
			'latin',
			$subset,
		);
	}

	// Append the subset string.
	if ( ! empty( $subsets ) ) {
		$request .= '&subset=' . join( ',', $subsets );
	}

	return esc_url_raw( $request );
}
endif;

if ( ! function_exists( 'stag_choose_google_font_variants' ) ) :
/**
 * Given a font, chose the variants to load for the theme.
 *
 * Attempts to load regular, italic, and 700. If regular is not found, the first variant in the family is chosen. italic
 * and 700 are only loaded if found. No fallbacks are loaded for those fonts.
 *
 * @since  1.0.0.
 *
 * @param  string $font        The font to load variants for.
 * @param  array  $variants    The variants for the font.
 * @return array               The chosen variants.
 */
function stag_choose_google_font_variants( $font, $variants = array() ) {
	$chosen_variants = array();
	if ( empty( $variants ) ) {
		$fonts = stag_get_google_fonts();

		if ( array_key_exists( $font, $fonts ) ) {
			$variants = $fonts[ $font ]['variants'];
		}
	}

	// If a "regular" variant is not found, get the first variant.
	if ( ! in_array( 'regular', $variants, true ) ) {
		$chosen_variants[] = $variants[0];
	} else {
		$chosen_variants[] = 'regular';
	}

	// Only add "italic" if it exists.
	if ( in_array( 'italic', $variants, true ) ) {
		$chosen_variants[] = 'italic';
	}

	// Only add "700" if it exists.
	if ( in_array( '700', $variants, true ) ) {
		$chosen_variants[] = '700';
	}

	return apply_filters( 'stag_font_variants', array_unique( $chosen_variants ), $font, $variants );
}
endif;

if ( ! function_exists( 'stag_sanitize_font_subset' ) ) :
/**
 * Sanitize the Character Subset choice.
 *
 * @since  1.0.0
 *
 * @param  string $value    The value to sanitize.
 * @return array            The sanitized value.
 */
function stag_sanitize_font_subset( $value ) {
	if ( ! array_key_exists( $value, stag_get_google_font_subsets() ) ) {
		$value = 'latin';
	}

	return $value;
}
endif;

if ( ! function_exists( 'stag_get_google_font_subsets' ) ) :
/**
 * Retrieve the list of available Google font subsets.
 *
 * @since  1.0.0.
 *
 * @return array    The available subsets.
 */
function stag_get_google_font_subsets() {
	return array(
		'all'          => __( 'All', 'stag' ),
		'arabic'       => __( 'Arabic', 'stag' ),
		'bengali'      => __( 'Bengali', 'stag' ),
		'cyrillic'     => __( 'Cyrillic', 'stag' ),
		'cyrillic-ext' => __( 'Cyrillic Extended', 'stag' ),
		'devanagari'   => __( 'Devanagari', 'stag' ),
		'greek'        => __( 'Greek', 'stag' ),
		'greek-ext'    => __( 'Greek Extended', 'stag' ),
		'gujarati'     => __( 'Gujarati', 'stag' ),
		'gurmukhi'     => __( 'Gurmukhi', 'stag' ),
		'hebrew'       => __( 'Hebrew', 'stag' ),
		'kannada'      => __( 'Kannada', 'stag' ),
		'khmer'        => __( 'Khmer', 'stag' ),
		'latin'        => __( 'Latin', 'stag' ),
		'latin-ext'    => __( 'Latin Extended', 'stag' ),
		'malayalam'    => __( 'Malayalam', 'stag' ),
		'myanmar'      => __( 'Myanmar', 'stag' ),
		'oriya'        => __( 'Oriya', 'stag' ),
		'sinhala'      => __( 'Sinhala', 'stag' ),
		'tamil'        => __( 'Tamil', 'stag' ),
		'telugu'       => __( 'Telugu', 'stag' ),
		'thai'         => __( 'Thai', 'stag' ),
		'vietnamese'   => __( 'Vietnamese', 'stag' ),
	);
}
endif;

if ( ! function_exists( 'stag_sanitize_font_choice' ) ) :
/**
 * Sanitize a font choice.
 *
 * @since  1.0.0.
 *
 * @param  string $value The font choice.
 * @return string The sanitized font choice.
 */
function stag_sanitize_font_choice( $value ) {
	if ( is_int( $value ) ) {
		// The array key is an integer, so the chosen option is a heading, not a real choice.
		return '';
	} elseif ( array_key_exists( $value, stag_all_font_choices() ) ) {
		return $value;
	} else {
		return '';
	}
}
endif;

if ( ! function_exists( 'stag_get_all_fonts' ) ) :
/**
 * Compile font options from different sources.
 *
 * @since  1.0.0.
 *
 * @return array    All available fonts.
 */
function stag_get_all_fonts() {
	$standard_fonts = stag_get_standard_fonts();
	$google_fonts   = stag_get_google_fonts();

	return apply_filters( 'stag_all_fonts', array_merge( $standard_fonts, $google_fonts ) );
}
endif;

if ( ! function_exists( 'stag_all_font_choices' ) ) :
/**
 * Packages the font choices into value/label pairs for use with the customizer.
 *
 * @since  1.0.0.
 *
 * @return array    The fonts in value/label pairs.
 */
function stag_all_font_choices() {
	$fonts   = stag_get_all_fonts();
	$choices = array();

	// Repackage the fonts into value/label pairs.
	foreach ( $fonts as $key => $font ) {
		$choices[ $key ] = $font['label'];
	}

	return $choices;
}
endif;

if ( ! function_exists( 'stag_get_standard_fonts' ) ) :
/**
 * Return an array of standard websafe fonts.
 *
 * @since  1.0.0.
 *
 * @return array    Standard websafe fonts.
 */
function stag_get_standard_fonts() {
	return array(
		'serif' => array(
			'label' => _x( 'Serif', 'font style', 'stag' ),
			'stack' => 'Georgia,Times,"Times New Roman",serif',
		),
		'sans-serif' => array(
			'label' => _x( 'Sans Serif', 'font style', 'stag' ),
			'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif',
		),
		'monospace' => array(
			'label' => _x( 'Monospaced', 'font style', 'stag' ),
			'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
		),
	);
}
endif;
