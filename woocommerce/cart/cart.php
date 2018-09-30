<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wc_print_notices();
do_action( 'woocommerce_before_cart' );

function get_order_backorder($_product, $cart_item){
	if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
		return esc_html__('(Available on backorder)', 'woocommerce');
	}
	return FALSE;
}

function get_product_quantity($_product, $cart_item_key, $cart_item){
	if ($_product->is_sold_individually()) {
		$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
	} else {
		$product_quantity = woocommerce_quantity_input(array(
			'input_name' => "cart[{$cart_item_key}][qty]",
			'input_value' => $cart_item['quantity'],
			'max_value' => $_product->get_max_purchase_quantity(),
			'min_value' => '0',
		), $_product, false);
	}
	return apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
}

function get_cart_items(){
	$cartItems = [];
	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
		$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
		$product_permalink = '';
		if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
			$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
		}else{
			continue;
		}
		$cartItems[] = [
			'remove_link' => apply_filters('woocommerce_cart_item_remove_link', esc_url(WC()->cart->get_remove_url($cart_item_key))),
			'prod_thumb_src' => wp_get_attachment_image_src(get_post_thumbnail_id($_product->id))[0],
			'prod_title' => $_product->get_name(),
			'link' => $product_permalink,
			'backorder_notificaction' => get_order_backorder($_product, $cart_item),
			'price'=> apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key),
			'qty'=> get_product_quantity($_product, $cart_item_key, $cart_item),
			'subtotal'=> apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key)
		];	
	}
	return $cartItems;
}
?>

<div class="container my-3">
	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				<div class="col-12">
					<div class="bg-light p-2">
						<h3>Your Cart</h3>
					</div>
				</div>
			</div>
			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post"><?php foreach (get_cart_items() as $a => $cart_item) { ?>
				<div class="row woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
					<div class="col-md-4 my-auto">
						<img src="<?= $cart_item['prod_thumb_src'] ?>" class="img-fluid">
					</div>
					<div class="col-md-8 my-auto">
						<div class="row">
							<div class="col-md-8">
								<h5><?= ($cart_item['link']) ? '<a class="text-dark" href="' . $cart_item['link'] . '">' . $cart_item['prod_title'] . '</a>' : $cart_item['prod_title']; ?></h5>
							</div>
							<div class="col-md-4">
								<span class="text-warning font-weight-bold"><?= $cart_item['subtotal'] ?></span>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-2">
								<small>Qty: </small>
							</div>
							<div class="col-md-10">
								<small><?= $cart_item['qty'] ?></small>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-md-2">
								<small>Each:</small>
							</div>
							<div class="col-md-10">
								<small><?= $cart_item['price'] ?></small>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-md-4">
								<a class="btn btn-light btn-block" href="<?= $cart_item['remove_link'] ?>">Remove</a>
							</div>
							<div class="col-md-4">
								<a class="btn btn-light btn-block" href="<?= $cart_item['remove_link'] ?>">View Product</a>
							</div>
						</div>
					</div>
				</div><?php }?>
				<hr>
				<div class="row">
					<div class="col-md-6 offset-sm-3 text-right"><?php if ( wc_coupons_enabled() ) { ?>
						<div class="input-group">
							<input type="text" name="coupon_code" class="form-control mt-3" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
							<span class="input-group-btn">
								<input type="submit" class="btn btn-info mt-3" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
							</span>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div><?php } ?>
					</div>
					<div class="col-md-3 text-right">
						<input type="submit" class="btn btn-info btn-block mt-3" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>" />
					</div>
				</div>					
				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</form>
		</div>
		<div class="col-sm-4 bg-dark text-light">
			<?php do_action( 'woocommerce_cart_collaterals' );?>
		</div>
	</div>
</div>
