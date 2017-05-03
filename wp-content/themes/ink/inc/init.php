<?php
/**
 * Load theme files and partials.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

/**
 * Theme file includes directory.
 *
 * @var string
 */
$inc = get_template_directory() . '/inc/';

/**
 * Load components.
 */
require_once $inc . 'customizer.php';
require_once $inc . 'theme-functions.php';
require_once $inc . 'template-tags.php';
require_once $inc . 'extras.php';

/**
 * Post Metaboxes.
 */
require_once $inc . 'meta/post.php';

/**
 * Include widgets.
 */
require_once $inc . 'widgets/contributors.php';
require_once $inc . 'widgets/recent-posts-grid.php';
require_once $inc . 'widgets/recent-posts.php';
require_once $inc . 'widgets/static-content.php';
require_once $inc . 'widgets/feature-callout.php';
require_once $inc . 'widgets/featured-slide.php';
require_once $inc . 'widgets/section-featured-slides.php';
