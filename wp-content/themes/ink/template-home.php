<?php
/**
 * Template Name: Home
 */

// Get selected sidebar.
$sidebar = stag_get_post_meta( 'settings', get_the_ID(), 'page-sidebar' );

get_header(); ?>
	
	<div class="section">
		<div class="section__header">
		</div>
	</div>

	<div class="section">
		<h2 class="section__title section__title--centered">RECENT ARTICLES</h2>
		<div class="section__posts">
			<?php 
				$args = array(
				  'posts_per_page' => 9,
				  'orderby' => 'date',
				  'order' => 'DESC',
				  'category_name' => 'Artbook'
				);
				$loop = new WP_Query( $args );
			?>
			<?php while ( $loop->have_posts() ) : $loop->the_post();?>
				<article class="section__post">
					<div class="section__post-image">
						<a href="<?php the_permalink(); ?>">
							<img class="section__post-image-card filter-juno" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="image for post <?php the_title(); ?>">
						</a>
					</div>
					<div class="section__post-meta">
						<div class="section__post-meta-block">
							<div class="section__post-meta-title">Date</div>
							<div class="section__post-meta-value"><?php echo get_the_date('d. M Y'); ?></div>
						</div>
						<div class="section__post-meta-block">
							<div class="section__post-meta-title">Read Time</div>
							<div class="section__post-meta-value"><?php echo stag_post_reading_time(); ?></div>
						</div>
						<div class="section__post-meta-block">
							<div class="section__post-meta-title">Author</div>
							<div class="section__post-meta-value">
								<?php
									$author_id = get_the_author_meta( 'ID' );
									$author_name = get_the_author_meta( 'user_firstname', $author_id );;
									echo '<img class="avatar avatar--round avatar--xs avatar--inline" src="'.get_avatar_url($author_id).'"><span>'.$author_name.'</span>';
								?>
							</div>
						</div>
						<div class="section__post-meta-block">
							<div class="section__post-meta-title">Topics</div>
							<div class="section__post-meta-value">
								<?php 
									$post_tags = get_the_tags();
									$post_tags_string = '';
									if ( $post_tags ) {
										foreach( $post_tags as $tag ) {
											$post_tags_string .= '<span class="section__post-meta-label">' . $tag->name . '</span>';
										}
										echo $post_tags_string;
									}
								?>
							</div>
						</div>
					</div>
					<div class="section__post-content">
						<a href="<?php the_permalink(); ?>">
							<h4 class="section__post-content-title"><?php the_title(); ?></h4>
						</a>
						<p class="section__post-content-excerpt"><?php the_excerpt(); ?></p>
						<a href="<?php get_the_permalink() ?>" class="section__post-button">View Article</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="section__cta">
			<a href="https://nilsdannemann.com/category/artbook/" class="section__cta-button">View all Articles</a>
		</div>
	</div>

	<!-- <div class="section">
		<h2 class="section__title">Section Offers</h2>
		<div class="section__offers">
			<div class="grid__third">Offer</div>
			<div class="grid__third">Offer</div>
			<div class="grid__third">Offer</div>
		</div>
	</div> -->

<?php
get_footer();
