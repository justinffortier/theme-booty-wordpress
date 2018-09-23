<?php
/**
 * The template for displaying all products in basic loop
 *
 * Template Name: Basic Shop Page
 *
 * @package Bootstrap
 */

get_header(); ?>
<div class="container">
	<?php echo do_shortcode('[products]');?>
</div>
<?php get_footer();?>
