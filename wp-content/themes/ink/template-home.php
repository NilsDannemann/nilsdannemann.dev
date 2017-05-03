<?php
/**
 * Template Name: Template - Home
 *
 * Template for the Start page.
 *
 * @package Stag_Customizer
 * @since 1.1.0.
 */

get_header(); ?>

<div class="hero">
	Hero
</div>

<main id="main" class="site-main">
	<?php get_template_part( 'content', 'single' ); ?>
</main>

<?php get_footer();
