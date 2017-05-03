<?php
/**
 * Display featured slide item for featured sliders.
 *
 * @package Ink
 */
class Stag_Widget_Featured_Slide_Item extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_widget_feature_slide';
		$this->widget_cssclass    = 'stag_widget_feature_slide full-wrap';
		$this->widget_description = esc_html__( 'Displays a feature slide.', 'stag' );
		$this->widget_name        = esc_html__( 'Featured Slide Item', 'stag' );
		$this->settings           = array(
			'background_image' => array(
					'type'  => 'image',
					'std'   => null,
					'label' => esc_html__( 'Background Image:', 'stag' ),
				),
				'content_text' => array(
					'type'  => 'textarea',
					'std'   => '',
					'label' => esc_html__( 'Content:', 'stag' ),
					'rows'  => 5,
				),
				'box_color' => array(
					'type'  => 'colorpicker',
					'std'   => '#fff',
					'label' => esc_html__( 'Content Box Color:', 'stag' ),
				),
				'box_opacity' => array(
					'type'  => 'number',
					'std'   => 100,
					'step'  => 5,
					'min'   => 0,
					'max'   => 100,
					'label' => esc_html__( 'Content Box Opacity:', 'stag' ),
				),
				'button_link' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button URL:', 'stag' ),
				),
				'button_text' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button Text:', 'stag' ),
				),
		);

		parent::__construct();

		add_filter( 'stag_slide_item_description', 'wptexturize' );
		add_filter( 'stag_slide_item_description', 'convert_smilies' );
		add_filter( 'stag_slide_item_description', 'convert_chars' );
		add_filter( 'stag_slide_item_description', 'wpautop' );
		add_filter( 'stag_slide_item_description', 'shortcode_unautop' );
		add_filter( 'stag_slide_item_description', 'prepend_attachment' );
		add_filter( 'stag_slide_item_description', 'do_shortcode' );
	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		extract( $args );

		$background_image = esc_url( $instance['background_image'] );
		$button_link      = esc_url( $instance['button_link'] );
		$button_text      = strip_tags( $instance['button_text'] );
		$box_color        = stag_maybe_hash_hex_color( $instance['box_color'] );
		$box_opacity      = absint( $instance['box_opacity'] );
		$content_text     = $this->box_content( $instance );

		echo  $before_widget;

		?>

		<style type="text/css">
			#<?php echo esc_attr( $this->id ); ?> .slide-desc-cover {
				opacity: <?php echo absint( $box_opacity ) / 100; ?>;
				background-color: <?php echo esc_html( $box_color ); ?>;
			}
		</style>

		<?php if ( 0 === absint( $box_opacity ) ) : ?>
		<style type="text/css">
			#<?php echo esc_attr( $this->id ); ?> .slide-desc {
				box-shadow: none;
			}
		</style>
		<?php endif; ?>

		<div class="bg-img" style="background-image:url(<?php echo esc_url( $background_image ); ?>);"></div>
		<!-- <div class="container"> -->
		<div class="slide-desc-wrapper">
			<div class="container">
				<div class="slide-desc">
					<span class="slide-desc-cover"></span>
					<div class="slide-desc-content">
						<?php echo $content_text; ?>
						<?php if ( '' !== $button_text ) : ?>
							<a class="button alt accent-background" href="<?php echo $button_link; ?>"><?php echo $button_text; ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- </div> -->

		<?php

		echo  $after_widget;

		wp_reset_postdata();

		$content = ob_get_clean();

		echo apply_filters( $this->widget_id, $content );

		$this->cache_widget( $args, $content );
	}

	private function box_content( $instance ) {
		$content = isset( $instance['content_text'] ) ? $instance['content_text'] : '';

		$output  = wpautop( $content );
		$output  = apply_filters( 'stag_slide_item_description', $output );

		return $output;
	}

	/**
	 * Registers the widget with the WordPress Widget API.
	 *
	 * @return mixed
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}
}

add_action( 'widgets_init', array( 'Stag_Widget_Featured_Slide_Item', 'register' ) );
