<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Shop Page
 *
 * @package storefront
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="col-lg-12">
			<main id="main" class="site-main" role="main">
				<div class="row">
					heello
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'downloads' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; // end of the loop. ?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
	</div>
</div>

<?php
get_footer();
