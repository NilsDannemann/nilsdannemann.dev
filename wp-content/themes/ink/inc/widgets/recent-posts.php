<?php
/**
 * Custom Recent Posts
 *
 * @since Ink 1.0
 */
class Stag_Widget_Recent_Posts extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_widget_recent_posts';
		$this->widget_cssclass    = 'stag_widget_recent_posts full-wrap';
		$this->widget_description = __( 'Displays recent posts from Blog.', 'stag' );
		$this->widget_name        = __( 'Section: Recent Posts', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Latest Posts',
				'label' => __( 'Title:', 'stag' ),
			),
			'description' => array(
				'type'  => 'textarea',
				'std'   => null,
				'rows'  => '5',
				'label' => __( 'Description:', 'stag' ),
			),
			'count' => array(
				'type'  => 'number',
				'std'   => '3',
				'label' => __( 'Number of posts to show:', 'stag' ),
			),
			'post_date' => array(
				'type'  => 'checkbox',
				'std'   => 'on',
				'label' => __( 'Show Post Meta?', 'stag' ),
			),
			'category' => array(
				'type'  => 'category',
				'std'   => '0',
				'label' => __( 'Post Category:', 'stag' ),
			),
			'bg_color' => array(
				'type'  => 'colorpicker',
				'std'   => stag_theme_mod( 'colors', 'accent' ),
				'label' => __( 'Background Color:', 'stag' ),
			),
			'bg_opacity' => array(
				'type'  => 'number',
				'std'   => '20',
				'step'  => '5',
				'min'   => '0',
				'max'   => '100',
				'label' => __( 'Background Image Opacity:', 'stag' ),
			),
			'bg_image' => array(
				'type'  => 'image',
				'std'   => null,
				'label' => __( 'Background Image:', 'stag' ),
			),
			'text_color' => array(
				'type'  => 'colorpicker',
				'std'   => '#ffffff',
				'label' => __( 'Text Color:', 'stag' ),
			),
			'link_color' => array(
				'type'  => 'colorpicker',
				'std'   => '#f8f8f8',
				'label' => __( 'Link Color:', 'stag' ),
			),
		);

		parent::__construct();
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

		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$description = isset( $instance['description'] ) ? $instance['description'] : '';
		$count       = $instance['count'];
		$post_date   = $instance['post_date'];
		$category    = $instance['category'];
		$bg_color    = $instance['bg_color'];
		$bg_opacity  = $instance['bg_opacity'];
		$bg_image    = $instance['bg_image'];
		$text_color  = $instance['text_color'];
		$link_color  = $instance['link_color'];
		$posts       = wp_get_recent_posts( array( 'post_type' => 'post', 'numberposts' => $count, 'post_status' => 'publish', 'category' => $category ), OBJECT );

		$posts_page = get_option( 'page_for_posts' );

		// If category not selected.
		if ( 0 === absint( $category ) ) {
			if ( 0 === absint( $posts_page ) ) {
				$posts_page = home_url();
			} else {
				$posts_page = get_permalink( $posts_page );
			}
		} else {
			// if category selected.
			$posts_page = get_category_link( absint( $category ) );
		}

		global $post;

		echo $before_widget;
		?>

		<style type="text/css">
			#<?php echo $widget_id; ?> {
				background-color: <?php echo $bg_color; ?>;
				color: <?php echo $text_color; ?>;
			}
			#<?php echo $widget_id; ?> .static-content-cover {
				background-image: url(<?php echo esc_url( $bg_image ); ?>);
				opacity: <?php echo $bg_opacity/100; ?>;
			}
			#<?php echo $widget_id; ?> a:not(.button) {
				color: <?php echo $link_color; ?>;
				border-color: <?php echo $link_color; ?>;;
			}

			#<?php echo $widget_id; ?> h1,
			#<?php echo $widget_id; ?> h2,
			#<?php echo $widget_id; ?> h3,
			#<?php echo $widget_id; ?> h4,
			#<?php echo $widget_id; ?> h5,
			#<?php echo $widget_id; ?> h6 {
				color: <?php echo $text_color; ?>;
			}

		</style>
		<div class="static-content-cover"></div>

		<section class="inner-section">
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>

			<div class="entry-content">
				<?php echo apply_filters( 'the_content', $description ); ?>
			</div>

			<?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>

				<?php // Add subtitles support.
				add_filter( 'subtitle_view_supported', '__return_true' ); ?>

				<article id="post-<?php the_ID(); ?>">
					<header class="entry-header">
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					</header><!-- .entry-header -->

					<?php if ( '' !== $post_date  ) : ?>
						<footer class="entry-meta">
							<?php stag_posted_on(); ?>
							<?php edit_post_link( __( 'Edit', 'stag' ), '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-meta -->
					<?php endif; ?>
				</article>


			<?php endforeach; ?>
			<?php remove_all_filters( 'subtitle_view_supported' ); ?>
			<?php wp_reset_postdata(); ?>

			<a href="<?php echo $posts_page; ?>" class="button all-posts"><?php _e( 'See All Posts', 'stag' ); ?></a>
		</section>

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	/**
	 * Registers the widget with the WordPress Widget API.
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}
}

add_action( 'widgets_init', array( 'Stag_Widget_Recent_Posts', 'register' ) );
