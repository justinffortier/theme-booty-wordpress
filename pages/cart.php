<?php

/**
 * The template for displaying all products in basic loop
 *
 * Template Name: Cart Page
 *
 * @package Bootstrap
 */
get_header();
?>
<?php echo do_shortcode('[woocommerce_cart]'); ?>

<?php
get_footer();
