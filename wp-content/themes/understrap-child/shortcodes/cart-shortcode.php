<?php
//code for cart addon
add_shortcode( 'woo_cart_but', 'woo_cart_but' );
/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function woo_cart_but() {
	ob_start();
	$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count.
	$cart_url   = wc_get_cart_url(); // Set Cart URL.

	?>
  <a class="menu-item cart-contents" href="<?php echo $cart_url; ?>" title="Shopping Cart">
        <span class="cart-contents-count-wrapper">
          <img src="<?php echo get_stylesheet_directory_uri() . '/images/cart.svg'?>" alt="Shopping Cart Icon">
          <span class="cart-contents-count"><?php echo $cart_count; ?></span>
        </span>
        <span class="cart-contents-total-amount"><?php echo WC()->cart->get_cart_total(); ?></span>
  </a>
	<?php
	return ob_get_clean();
}
