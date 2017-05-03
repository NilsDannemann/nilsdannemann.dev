<?php
/**
 * Ink theme customizer settings.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

function stag_customize_register_sections( $wp_customize ) {
	$wp_customize->add_panel( 'ink_options_panel', array(
		'title'       => esc_html__( 'Theme Options', 'stag' ),
		'description' => esc_html__( 'Configure your theme settings', 'stag' ),
		'priority' => 999,
	) );

	$wp_customize->add_section( 'general_settings', array(
		'title'       => _x( 'General Settings', 'Theme customizer section title', 'stag' ),
		'priority'    => 30,
		'panel'       => 'ink_options_panel',
		'description' => __( 'Upload site logo, and Google Analytics tracking code.', 'stag' ),
	) );

	$wp_customize->add_section( 'layout_options', array(
		'title'       => _x( 'Styling Options', 'Theme customizer section title', 'stag' ),
		'priority'    => 40,
		'panel'       => 'ink_options_panel',
	) );

	$wp_customize->add_section( 'typography', array(
		'title'       => _x( 'Typography Options', 'Theme customizer section title', 'stag' ),
		'priority'    => 60,
		'panel'       => 'ink_options_panel',
		'description' => sprintf(
			esc_html__( 'The list of Google fonts is long! You can %s before making your choices.', 'stag' ),
			sprintf(
				'<a href="%1$s" target="_blank" class="external-link">%2$s</a>',
				esc_url( 'https://fonts.google.com' ),
				esc_html__( 'preview', 'stag' )
			)
		),
	) );

	$wp_customize->add_section( 'post_settings', array(
		'title'       => _x( 'Post Settings', 'Theme customizer section title', 'stag' ),
		'priority'    => 100,
		'panel'       => 'ink_options_panel',
	) );

	$wp_customize->add_section( 'stag_footer', array(
		'title'      => _x( 'Footer', 'Theme customizer section title', 'stag' ),
		'priority'   => 900,
		'panel'       => 'ink_options_panel',
	) );

	$wp_customize->add_section( '404_page', array(
		'title'       => _x( '404 Error Page', 'Theme customizer section title', 'stag' ),
		'priority'    => 910,
		'panel'       => 'ink_options_panel',
		'description' => __( 'Select a custom 404 page.', 'stag' ),
	) );
}
add_action( 'customize_register', 'stag_customize_register_sections' );

/**
 * Default theme customizations.
 *
 * @param var $args Option arguments.
 * @return $options an array of default theme options
 */
function stag_get_theme_mods( $args = array() ) {
	$defaults = array(
		'keys_only' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	$fonts = stag_all_font_choices();

	$mods = array(
		'title_tagline' => array(
			'hide-tagline' => array(
				'title'             => __( 'Hide Tagline', 'stag' ),
				'type'              => 'checkbox',
				'default'           => 0,
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			),
		),
		'header_image' => array(
			'header-image-text' => array(
				'title'             => esc_html__( 'Header Image Text', 'stag' ),
				'type'              => 'text',
				'default'           => '',
				'transport'         => 'postMessage',
				'priority'          => 0,
				'sanitize_callback' => 'ink_sanitize_text',
			),
			'header-image-description' => array(
				'title'     		=> esc_html__( 'Header Image Description', 'stag' ),
				'type'      		=> 'Stag_Customize_Textarea_Control',
				'default'   		=> null,
				'transport' 		=> 'postMessage',
				'priority'  		=> 0,
			),
			'header-image-cover' => array(
				'title'     		=> esc_html__( 'Background Color', 'stag' ),
				'type'      		=> 'WP_Customize_Color_Control',
				'default'   		=> '#000',
				'transport'         => 'postMessage',
				'priority'  		=> 0,
			),
			'header-image-opacity' => array(
				'title'             => esc_html__( 'Header Image Opacity', 'stag' ),
				'type'              => 'range',
				'default'           => 80,
				'transport'         => 'postMessage',
				'priority'          => 0,
				'input_attrs' => array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 5,
			    ),
			    'sanitize_callback' => 'absint',
			),
		),
		'general_settings' => array(
			'contact_email' => array(
				'title'   => __( 'Contact Form Email Address', 'stag' ),
				'type'    => 'text',
				'default' => null,
				'priority' => 90,
			),
			'google_analytics' => array(
				'title'   => __( 'Google Analytics Tracking Code', 'stag' ),
				'type'    => 'Stag_Customize_Textarea_Control',
				'description' => esc_html__( 'Paste the full Google Analytics code snippet here without <script> tags.', 'stag' ),
				'default' => null,
				'priority' => 100,
			),
		),
		'colors' => array(
			'background' => array(
				'title'   => __( 'Background Color', 'stag' ),
				'type'    => 'WP_Customize_Color_Control',
				'default' => '#ffffff',
			),
			'accent' => array(
				'title'   => __( 'Accent Color', 'stag' ),
				'type'    => 'WP_Customize_Color_Control',
				'default' => '#53b38c',
			),
		),
		'layout_options' => array(
			'layout' => array(
				'title'   => __( 'Homepage Layout', 'stag' ),
				'type'    => 'Stag_Customizer_Layout_Control',
				'default' => '1-2-1-2',
				'choices' => array(
					'1-2-1-2' => '1-2-1-2',
					'1-1-1-1' => '1-1-1-1',
					'1-2-2-2' => '1-2-2-2',
					'2-2-2-2' => '2-2-2-2',
					'3-3-3-3' => '3-3-3-3',
					'3-7-7-3' => '3-7-7-3',
				),
			),
			'hover-effect' => array(
				'title'             => __( 'Enable Post Grid Hover Effect', 'stag' ),
				'type'              => 'checkbox',
				'default'           => 0,
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			),
			'post-sidebar' => array(
				'title'             => __( 'Enable Sidebar on Single Post', 'stag' ),
				'type'              => 'checkbox',
				'default'           => 0,
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			),
			'page-sidebar' => array(
				'title'             => __( 'Enable Sidebar on Single Page', 'stag' ),
				'type'              => 'checkbox',
				'default'           => 0,
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			),
			'post-grid-hover-text' => array(
				'title'     => __( 'Post Grid Hover Text', 'stag' ),
				'type'      => 'text',
				'default'   => esc_html__( 'Read Story', 'stag' ),
				'transport' => 'refresh',
			),
			'nav-layout' => array(
				'title'     => __( 'Navigation Layout', 'stag' ),
				'type'      => 'radio',
				'default'   => 'sidebar',
				'transport' => 'refresh',
				'choices' 	=> array(
					'traditional' => __( 'Traditional', 'stag' ),
					'sidebar'     => __( 'Sidebar', 'stag' ),
				),
			),
		),
		'typography' => array(
			'body_font' => array(
				'title'     => __( 'Body Font', 'stag' ),
				'type'      => 'select',
				'default'   => 'Roboto',
				'transport' => 'refresh',
				'choices'   => $fonts,
			),
			'header_font' => array(
				'title'     => __( 'Header Font', 'stag' ),
				'type'      => 'select',
				'default'   => 'Montserrat',
				'transport' => 'refresh',
				'choices'   => $fonts,
			),
			'subset' => array(
				'title'    => __( 'Character Subset', 'stag' ),
				'type'     => 'select',
				'default'  => 'latin',
				'choices'  => stag_get_google_font_subsets(),
			),
		),
		'post_settings' => array(
			'single_post_heading' => array(
				'title'             => '',
				'type'              => 'Stag_Customize_Misc_Control',
				'default'           => false,
				'description'       => esc_html__( 'Single Posts', 'stag' ),
				'option'            => 'heading',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'hide_post_navigation' => array(
				'title'   => __( 'Hide next/previous post navigation', 'stag' ),
				'description' => esc_html__( 'Show/hide Next and Previous post navigation box', 'stag' ),
				'type'    => 'checkbox',
				'default' => 0,
				'transport' => 'refresh',
			),
			'show_related_posts' => array(
				'title'   => __( 'Show Related Posts', 'stag' ),
				'type'    => 'checkbox',
				'default' => 0,
				'transport' => 'refresh',
			),
			'related_posts_count' => array(
				'title'   => __( 'Number of Related posts to show', 'stag' ),
				'type'    => 'text',
				'default' => '2',
			),
			'scroll_text' => array(
				'title'     => __( 'Post Cover Scroll Text', 'stag' ),
				'type'      => 'text',
				'default'   => esc_html__( 'Scroll this', 'stag' ),
				'transport' => 'refresh',
				'description' => esc_html__( 'Scroll button text, appears over post covers on single posts.', 'stag' ),
			),
			'premium_text' => array(
				'title'           => __( 'Premium Post Text', 'stag' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Premium', 'stag' ),
				'transport'       => 'postMessage',
				'description'     => esc_html__( 'Display a text label for restricted post when Restrict Content Pro is active.', 'stag' ),
				'active_callback' => 'stag_is_rcp_active',
			),
			'sticky_text' => array(
				'title'           => __( 'Sticky Post Label', 'stag' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Sticky', 'stag' ),
				'transport'       => 'postMessage',
				'description'     => esc_html__( 'Display a text label for sticky post', 'stag' ),
			),
			'comments_visibility' => array(
				'title'     => __( 'Comments Visibility', 'stag' ),
				'type'      => 'radio',
				'default'   => 'visible',
				'transport' => 'refresh',
				'choices' 	=> array(
					'visible'   => __( 'Visible', 'stag' ),
					'collapsed' => __( 'Collapsed', 'stag' ),
				),
			),
			'single_post_line' => array(
				'title'             => '',
				'type'              => 'Stag_Customize_Misc_Control',
				'default'           => false,
				'option'            => 'line',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'post_info_heading' => array(
				'title'             => '',
				'type'              => 'Stag_Customize_Misc_Control',
				'default'           => false,
				'description'       => esc_html__( 'Post Info', 'stag' ),
				'option'            => 'heading',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'post_categories' => array(
				'title'     => __( 'Show Post Category', 'stag' ),
				'type'      => 'checkbox',
				'default'   => 0,
				'transport' => 'refresh',
			),
			'hide_author_title' => array(
				'title'   => __( 'Hide Author', 'stag' ),
				'type'    => 'checkbox',
				'default' => 0,
			),
			'hide_reading_time' => array(
				'title'     => __( 'Hide Reading Time', 'stag' ),
				'type'      => 'checkbox',
				'default'   => 0,
			),
			'show_excerpt' => array(
				'title'     => __( 'Show Post Excerpt (only at Blog pages)', 'stag' ),
				'type'      => 'checkbox',
				'default'   => 0,
				'transport' => 'refresh',
			),
			'excerpt_length' => array(
				'title'     => __( 'Post Excerpt Length (in words)', 'stag' ),
				'type'      => 'text',
				'default'   => '25',
				'transport' => 'refresh',
			),
		),
		'stag_footer' => array(
			'footer-widget-areas' => array(
				'title'       => esc_html__( 'Number of Widget Areas', 'stag' ),
				'type'        => 'select',
				'description' => esc_html__( 'Defines the number of columns shown in footer widget area.', 'stag' ),
				'default'     => '2',
				'transport'   => 'refresh',
				'choices'     => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				),
			),
			'copyright' => array(
				'title'   => __( 'Copyright Text', 'stag' ),
				'type'    => 'Stag_Customize_Textarea_Control',
				'default' => sprintf( 'Copyright &copy; %d — Made with &hearts; and intention by %s', date( 'Y' ), '<a href="https://codestag.com">Codestag</a>' ),
			),
		),
		'404_page' => array(
			'404_custom_page' => array(
				'title'   => __( 'Custom 404 Page', 'stag' ),
				'type'    => 'dropdown-pages',
				'allow_addition' => true,
				'default' => '0',
			),
		),
	);

	$mods = apply_filters( 'stag_theme_mods', $mods );

	/** Return all keys within all sections (for transport, etc) */
	if ( $args['keys_only'] ) {
		$transport = array();

		foreach ( $mods as $section => $settings ) {
			foreach ( $settings as $key => $setting ) {
				if ( isset( $setting['transport'] ) ) {
					$transport[ $key ] = $setting['transport'];
				} else {
					$transport[ $key ] = '';
				}
			}
		}

		return $transport;
	}

	return $mods;
}

/**
 * Output the basic extra CSS for primary and accent colors.
 * Split away from widget colors for brevity.
 *
 * @return void
 */
function stag_header_css() {
	?>
	<style id="stag-custom-css" type="text/css">
		body,
		.site,
		hr:not(.stag-divider)::before,
		.stag-divider--plain::before {
			background-color: <?php echo stag_theme_mod( 'colors', 'background' ); ?>;
		}
		body, .entry-subtitle,
		.rcp_level_description,
		.rcp_price,
		.rcp_level_duration ,
		.rcp_lost_password a {
			font-family: "<?php echo stag_theme_mod( 'typography', 'body_font' ); ?>";
		}
		.archive-header__title span,
		.ink-contact-form .stag-alert {
			color: <?php echo stag_theme_mod( 'colors', 'accent' ); ?>;
		}
		.accent-background,
		.stag-button.instagram-follow-link,
		button,
		.button,
		.locked-options .stag-button,
		input[type="reset"],
		input[type="submit"],
		input[type="button"],
		.hover-overlay .post-content-overlay button:hover {
			background-color: <?php echo stag_theme_mod( 'colors', 'accent' ); ?>;
		}
		a,
		.widget-area .widget .textwidget a:not(.stag-button),
		.site-nav .textwidget a:not(.stag-button),
		.ink-contact-form .stag-alert {
			border-color: <?php echo stag_theme_mod( 'colors', 'accent' ); ?>;
		}
		h1, h2, h3, h4, h5, h6, .button, .stag-button, input[type="submit"], input[type="reset"],
		.button-secondary, legend, .rcp_subscription_level_name, .post-navigation, .article-cover__arrow, .post-content-overlay,
		.entry-title .entry-title-primary, .page-links,
		.rcp_form label,
		label,
		.widget_recent_entries .post-date,
		span.entry-subtitle.entry-subtitle,
		.custom-header-description,
		#infinite-handle,
		table th,
		.premium-tag,
		.sticky-tag {
			font-family: "<?php echo stag_theme_mod( 'typography', 'header_font' ); ?>";
		}
		.post-grid {
			border-color: <?php echo stag_theme_mod( 'colors', 'background' ); ?>;
		}

		.custom-header-cover {
			<?php
				$coverColor = stag_theme_mod( 'header_image', 'header-image-cover' );
				$coverOpacity = stag_theme_mod( 'header_image', 'header-image-opacity' );
				$imageOpacity = (100 - $coverOpacity) / 100;
			?>
			background-color: <?php echo $coverColor; ?>;
			opacity: <?php echo $imageOpacity; ?>;
		}

		<?php if ( true === stag_theme_mod( 'post_settings', 'hide_reading_time' ) ) : ?>
		.reading-time { display: none; }
		<?php endif; ?>

		<?php if ( true === stag_theme_mod( 'title_tagline', 'hide-tagline' ) ) : ?>
		.site-description { display: none; }
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'stag_header_css' );


/**
 * Layout Picker Control
 *
 * Attach the custom layout picker control to the `customize_register` action
 * so the WP_Customize_Control class is initiated.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function stag_customizer_layout_control( $wp_customize ) {
	class Stag_Customizer_Layout_Control extends WP_Customize_Control {
		public $type = 'layout';

		public function render_content() {

			$img_dir = get_template_directory_uri() . '/assets/img/';
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<ul>
			<?php

			foreach ( $this->choices as $key => $value ) {
				?>
				<li class="customizer-control-row">
					<input type="radio" value="<?php echo esc_attr( $key ) ?>" name="<?php echo $this->id; ?>" <?php echo $this->link(); ?> <?php if ( $this->value() === $key ) echo 'checked="checked"'; ?>>
					<label for="<?php echo $this->id;  ?>[key]"><?php echo $value; ?></label>
				</li>
				<?php
			}

			?> </ul> <?php
		}
	}
}
add_action( 'customize_register', 'stag_customizer_layout_control', 1, 1 );

function stag_customizer_layout_css() {
	wp_register_script( 'customizer-ui-js', get_template_directory_uri() . '/assets/js/customizer-ui.js', 'jquery' );
	wp_enqueue_script( 'customizer-ui-js' );
	?>
	<style type="text/css">
		.customizer-control-row {
			position: relative;
			display: inline-block;
			vertical-align: top;
			width: 78px;
			height: 60px;
			overflow: hidden;
			margin: 0 4px 7px 0;
			font: 0/0 a;
		}

		.customizer-control-row:nth-child(1) label { background-position: -10px -12px; }
		.customizer-control-row:nth-child(2) label { background-position: -98px -12px; }
		.customizer-control-row:nth-child(3) label { background-position: -188px -12px; }
		.customizer-control-row:nth-child(4) label { background-position: -10px -86px; }
		.customizer-control-row:nth-child(5) label { background-position: -98px -86px; }
		.customizer-control-row:nth-child(6) label { background-position: -188px -86px; }

		.customizer-control-row input {
			position: absolute;
			width: 100%;
			height: 100%;
			opacity: 0;
			margin: 0;
		}
		.customizer-control-row input,
		.customizer-control-row label {
			width: 100%;
		}
		.customizer-control-row label {
			height: 60px;
			background: url("<?php echo get_template_directory_uri(); ?>/assets/img/layout-normal.svg") no-repeat;
			display: block;
			box-sizing: border-box;
		}

		.customizer-control-row input[type="radio"]:checked + label {
			background-image: url("<?php echo get_template_directory_uri(); ?>/assets/img/layout-selected.svg");
		}

		#stag-loading {
			background: #333;
			padding: 10px 0;
			/*border-radius: 5px;*/
			color: white;
			width: 40px;
			position: absolute;
			top: 30px;
			right: 30px;
			text-align: center;
		}

		#stag-loading i {
			display: inline-block;
			-webkit-animation: rotate 400ms linear 0s infinite alternate;
			-moz-animation: rotate 400ms linear 0s infinite alternate;
			-ms-animation: rotate 400ms linear 0s infinite alternate;
			animation: rotate 400ms linear 0s infinite alternate;
		}

		#customize-control-favicon .attachment-media-view { display: none;  }

		@-webkit-keyframes rotate { 0% { -webkit-transform: rotate(0deg); } 100% { -webkit-transform: rotate(180deg); } }
		@-moz-keyframes rotate { 0% { -moz-transform: rotate(0deg); } 100% { -moz-transform: rotate(180deg); } }
		@keyframes rotate { 0% { transform: rotate(0deg); } 100% { transform: rotate(180deg); } }

		.accordion-section .customize-control-image .preview-thumbnail img {
			width: auto;
			height: auto;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_scripts', 'stag_customizer_layout_css' );

/**
 * Add Chosen for easier font selection.
 *
 * @since 2.1.0.
 * @return void
 */
function ink_customize_controls_enqueue_scripts() {
	// Styles.
	wp_enqueue_style(
		'chosen',
		get_template_directory_uri() . '/stag-customizer/libs/chosen/chosen' . STAG_SCRIPT_SUFFIX . '.css',
		array(),
		'1.6.2'
	);

	// Scripts.
	wp_enqueue_script(
		'chosen',
		get_template_directory_uri() . '/stag-customizer/libs/chosen/chosen.jquery' . STAG_SCRIPT_SUFFIX . '.js',
		array( 'jquery', 'customize-controls' ),
		'1.6.2',
		true
	);

	wp_enqueue_script(
		'customizer-sections',
		get_template_directory_uri() . '/stag-customizer/js/customizer-sections.js',
		array( 'customize-controls', 'chosen' ),
		STAG_THEME_VERSION,
		true
	);

	$localize = array(
		'fontOptions'               => ink_get_font_property_option_keys(),
		'chosen_no_results_default' => esc_html__( 'No results match', 'stag' ),
		'chosen_no_results_fonts'   => esc_html__( 'No matching fonts', 'stag' ),
	);

	// Localize the script.
	wp_localize_script(
		'customizer-sections',
		'chosenOptions',
		$localize
	);
}

add_action( 'customize_controls_enqueue_scripts', 'ink_customize_controls_enqueue_scripts' );

if ( ! function_exists( 'ink_get_font_property_option_keys' ) ) :
/**
 * Return all the option keys for the specified font property.
 *
 * @since  2.1.0.
 *
 * @return array Array of matching font option keys.
 */
function ink_get_font_property_option_keys() {
	$font_keys = array( 'body_font', 'header_font' );

	return $font_keys;
}
endif;
