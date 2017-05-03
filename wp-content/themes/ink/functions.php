<?php
/**
 * Theme related functions.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

// Set the theme's content width.
if ( ! isset( $content_width ) ) {
	$content_width = 970;
}

if ( ! function_exists( 'stag_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function stag_theme_setup() {
	/*
	 * Makes theme available for translation.
	 *
	 * Attempt to load text domain from child theme first.
	 * Translations can be added to the /languages/ directory.
	 */
	if ( ! load_theme_textdomain( 'stag', get_stylesheet_directory() . '/languages' ) ) {
		load_theme_textdomain( 'stag', get_template_directory() . '/languages' );
	}

	// This theme uses wp_nav_menu() in following locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'stag' ),
		'footer'  => __( 'Footer Menu', 'stag' ),
	) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', 'gallery', 'caption' ) );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 *
	 * @since 2.1.0
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Add theme support for selective refresh for widgets.
	 *
	 * @since 2.1.0.
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @since 2.1.0
	 */
	add_theme_support( 'custom-header', apply_filters( 'ink_custom_header_args', array(
		'width'       => 2000,
		'height'      => 800,
		'uploads'     => true,
		'flex-height' => true,
		'header-text' => false,
		'video'       => true,
	) ) );
}
endif; // Stag_theme_setup.
add_action( 'after_setup_theme', 'stag_theme_setup' );

/**
 * Customize video play/pause button in the custom header.
 *
 * @param array $settings Video settings.
 */
function ink_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . __( 'Play background video', 'stag' ) . '</span><i class="fa fa-play" aria-hidden="true"></i>';
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . __( 'Pause background video', 'stag' ) . '</span><i class="fa fa-pause" aria-hidden="true"></i>';
	return $settings;
}
add_filter( 'header_video_settings', 'ink_video_controls' );


/**
 * Register widget areas and widgets.
 *
 * @since 1.0
 */
function stag_sidebar_init() {
	// Register widget areas.
	register_sidebar(array(
		'name'          => __( 'Footer Widget Area 1', 'stag' ),
		'id'            => 'sidebar-footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		'description'   => ink_sidebar_description( 'sidebar-footer-1' ),
	));
	register_sidebar(array(
		'name'          => __( 'Footer Widget Area 2', 'stag' ),
		'id'            => 'sidebar-footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		'description'   => ink_sidebar_description( 'sidebar-footer-2' ),
	));
	register_sidebar(array(
		'name'          => __( 'Footer Widget Area 3', 'stag' ),
		'id'            => 'sidebar-footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		'description'   => ink_sidebar_description( 'sidebar-footer-3' ),
	));
	register_sidebar(array(
		'name'          => __( 'Side Drawer Widget Area', 'stag' ),
		'id'            => 'sidebar-drawer',
		'before_widget' => '<aside id="%1$s" class="site-nav__section %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
		'description'   => __( 'Sidebar drawer navigation widgets.', 'stag' ),
	));
	register_sidebar(array(
		'name'          => esc_html__( 'Featured Slider Section', 'stag' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Use only &ldquo;Featured Slide Item&rdquo; widget here.', 'stag' ),
		'before_widget' => '<li class="slide"><div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	register_sidebar( array(
		'name'          => esc_html__( 'Single Posts Sidebar', 'stag' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'An optional widget area for single posts.', 'stag' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Single Page Sidebar', 'stag' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'An optional widget area for single pages.', 'stag' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'stag_sidebar_init' );

/**
 * Enqueues scripts and styles for front end.
 */
function stag_scripts_styles() {

	$style_dependencies = array();

	// Google fonts.
	if ( '' !== $google_request = stag_get_google_font_uri() ) {
		// Enqueue the fonts.
		wp_enqueue_style(
			'stag-google-fonts',
			$google_request,
			$style_dependencies,
			STAG_THEME_VERSION
		);
		$style_dependencies[] = 'stag-google-fonts';
	}

	// Main stylesheet.
	wp_enqueue_style( 'stag-style', get_stylesheet_uri(), $style_dependencies, STAG_THEME_VERSION );

	// RTL Support.
	wp_style_add_data( 'stag-style', 'rtl', 'replace' );

	/**
	 * Remove default Subtitles plugin styles.
	 *
	 * @link https://wordpress.org/plugins/subtitles/
	 * @since 1.1.0
	 */
	wp_dequeue_style( 'subtitles-style' );

	if ( ! wp_script_is( 'font-awesome', 'registered' ) ) {
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' , array(), '4.7.0', 'all' );
	}
	wp_enqueue_style( 'font-awesome' );

	wp_register_script( 'stag-custom', get_template_directory_uri() . '/assets/js/jquery.custom' . STAG_SCRIPT_SUFFIX . '.js', array( 'jquery' ), STAG_THEME_VERSION, true );
	wp_register_script( 'stag-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array( 'jquery', 'stag-custom' ), STAG_THEME_VERSION, true );
	wp_register_script( 'fitvids', get_template_directory_uri() . '/assets/js/lib/fitvids/jquery.fitvids' . STAG_SCRIPT_SUFFIX . '.js', array( 'jquery' ), '1.1.1', true );

	// Default fitvids selectors.
	$selector_array = array(
		"iframe[src*='www.viddler.com']",
		"iframe[src*='money.cnn.com']",
		"iframe[src*='www.educreations.com']",
		"iframe[src*='//blip.tv']",
		"iframe[src*='//embed.ted.com']",
		"iframe[src*='//www.hulu.com']",
	);

	// Allow dev to customize the selectors.
	$fitvids_custom_selectors = apply_filters( 'stag_fitvids_custom_selectors', $selector_array );

	// Compile selectors.
	$fitvids_custom_selectors = array(
		'customSelector' => implode( ',', $fitvids_custom_selectors ),
	);

	// Send to the script.
	wp_localize_script(
		'stag-custom',
		'StagFitvidsCustomSelectors',
		$fitvids_custom_selectors
	);

	// Send to the script.
	wp_localize_script(
		'stag-custom',
		'postSettings',
		array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'stag-ajax' ),
			'category' => get_query_var( 'cat' ),
			'search'   => get_query_var( 's' ),
		)
	);

	// Enqueue Scripts.
	wp_enqueue_script( 'stag-plugins' );

	if ( is_singular() ) {
		wp_enqueue_script( 'fitvids' );
	}

	// Comment reply.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' ); // Loads the javascript required for threaded comments.
	}

	// Add tracking code.
	$tracking_code = stag_theme_mod( 'general_settings', 'google_analytics' );
	if ( '' !== $tracking_code ) {
		wp_add_inline_script( 'stag-custom', $tracking_code );
	}
}
add_action( 'wp_enqueue_scripts', 'stag_scripts_styles' );

/**
 * Enqueue theme scripts.
 */
function stag_maybe_enqueue_spin() {
	// Register spinner scripts.
	wp_enqueue_script(
		'spin',
		get_template_directory_uri() . '/assets/js/lib/spin/spin' . STAG_SCRIPT_SUFFIX . '.js',
		array(),
		'1.3'
	);

	wp_enqueue_script(
		'jquery.spin',
		get_template_directory_uri() . '/assets/js/lib/spin/jquery.spin' . STAG_SCRIPT_SUFFIX . '.js',
		array( 'jquery', 'spin' ),
		'1.3'
	);
}
add_action( 'wp_enqueue_scripts', 'stag_maybe_enqueue_spin' );

if ( ! function_exists( 'stag_early_head_times' ) ) :
/**
 * Items to add before other scripts and styles load in the head.
 *
 * @since 1.0
 */
function stag_early_head_times() {
	?>
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<?php
}
endif;


global $wp_version;
if ( version_compare( $wp_version, '4.6', '<' ) ) {
	add_action( 'wp_head', 'stag_early_head_times', 1 );
}

/**
 * Register the required plugins for this theme.
 *
 * @since 1.0.0
 *
 * @return void
 */
function stag_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'StagTools',
			'slug'     => 'stagtools',
			'required' => true,
		),
		array(
			'name'     => 'Stag Custom Sidebars',
			'slug'     => 'stag-custom-sidebars',
			'required' => true,
		),
		array(
			'name'     => 'Jetpack',
			'slug'     => 'jetpack',
			'required' => false,
		),
		array(
			'name'         => 'Envato Market',
			'slug'         => 'wp-envato-market',
			'source'       => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'required'     => false,
			'version'      => '1.0.0-RC2',
			'external_url' => 'https://github.com/envato/wp-envato-market/',
		),
	);

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'stag_required_plugins' );

$tmp_dir = get_template_directory();

/**
 * Include Stag_Customizer class.
 */
include_once( $tmp_dir . '/stag-customizer/stag-customizer.php' );

/**
 * Include theme partials: widgets, metaboxes and rest.
 */
include_once( $tmp_dir . '/inc/init.php' );

/**
 * Include Restrict Content Pro related files.
 *
 * @link http://pippinsplugins.com/restrict-content-pro-premium-content-plugin/
 */
include_once( $tmp_dir . '/rcp/init.php' );
