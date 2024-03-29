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
		<h2 class="section__title section__title--centered">ARTICLES</h2>
		<div class="section__posts">
			<?php 
				$args = array(
				  'posts_per_page' => 30,
				  'orderby' => 'date',
				  'order' => 'DESC',
				  'category_name' => 'Artbook'
				);
				$loop = new WP_Query( $args );
			?>
			<?php while ( $loop->have_posts() ) : $loop->the_post();?>
				<article id="post-<?php the_ID(); ?>" class="section__post">
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
											$post_tags_string .= '<a class="section__post-meta-label" href="'.get_tag_link($tag->term_id).'">' . $tag->name . '</a>';
										}
										echo $post_tags_string;
									}
								?>
							</div>
						</div>
					</div>
					<div class="section__post-content">
						<a href="<?php the_permalink(); ?>">
							<h2 class="section__post-content-title"><?php the_title(); ?></h2>
						</a>
						<div class="section__post-content-excerpt">
							<div class="excerpt-content" action-id="<?php the_ID(); ?>">
			                    <?php the_excerpt(); ?>
			                </div>
			                <div class="full-content" action-id="<?php the_ID(); ?>" style="display: none;">
								<?php 
				                    $the_content = get_the_content();
				                    $the_content = str_replace('<h2>', '<h3>', $the_content);
				                    $the_content = str_replace('</h2>', '</h3>', $the_content);
				                    echo $the_content;
			                    ?>
			                </div>
						</div>
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
