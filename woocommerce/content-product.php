<?php
/**
 * The template for displaying product content within loops
 *
 * @package Bootstrap
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="col-sm-4 h-100">
	<div class="card my-3">
		<img class="card-img-top" src="..." alt="">
		<div class="card-body" style="height:250px">
			<h5 class="card-title"><?php do_action( 'woocommerce_shop_loop_item_title' );?></h5>
		</div>
		<div class="card-footer text-center">
			<div>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' );?>
			</div>
			<div>
				<?php do_action( 'woocommerce_after_shop_loop_item' );?>
			</div>
		</div>
	</div>
</div>
