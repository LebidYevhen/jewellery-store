<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}

add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );


/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,700;1,500&family=Marcellus&display=swap' );
	wp_enqueue_style( 'swiper-styles', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
	wp_enqueue_script( 'swiper-scripts', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js' );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'add_child_theme_textdomain' );


/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}

add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );


/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}

add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );


/**
 * Adds svg support.
 */
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'cc_mime_types' );


require_once 'shortcodes/cart-shortcode.php';


/**
 * Adds search box to primary menu.
 */
function wpgood_nav_search( $items, $args ) {
	// If this isn't the primary menu, do nothing.
	if ( ! ( $args->theme_location == 'primary' ) ) {
		return $items;
	}

  $search_form_element = '<li class="menu-item search-form-element">' . get_search_form( false ) . '</li>';
  $search_form_trigger = sprintf('<li class="menu-item search-form-trigger"><a href="javascript:void(0);"><img src="%s" alt="Search Icon"></a></li>', get_stylesheet_directory_uri() . '/images/search.svg');
	// Otherwise, add search form.
	$items .= $search_form_element . $search_form_trigger;
	$items .= do_shortcode( '[woo_cart_but]' ); // Adding the created Icon via the shortcode already created.

	return $items;
}

add_filter( 'wp_nav_menu_items', 'wpgood_nav_search', 10, 2 );


/**
 * Add AJAX Shortcode when cart contents update
 */
function woo_cart_but_count( $fragments ) {
	ob_start();
	$cart_count = WC()->cart->cart_contents_count;
	$cart_url   = wc_get_cart_url();

	?>
  <a class="menu-item cart-contents" href="<?php echo $cart_url; ?>" title="Shopping Cart">
		<span class="cart-contents-count-wrapper">
		  <img src="<?php echo get_stylesheet_directory_uri() . '/images/cart.svg'; ?>" alt="Shopping Cart Icon">
		  <span class="cart-contents-count"><?php echo $cart_count; ?></span>
		</span>
    <span class="cart-contents-total-amount"><?php echo WC()->cart->get_cart_total(); ?></span>
  </a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}

// Add a filter to get the cart count.
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );


/**
 * ACF functions
 */
function get_acf_field( $fieldName, $pid = null ) {
	return get_sub_field( $fieldName ) ? get_sub_field( $fieldName ) : get_field( $fieldName );
}

function the_acf_field( $fieldName, $pid = null ) {
	echo get_sub_field( $fieldName ) ? get_sub_field( $fieldName ) : get_field( $fieldName );
}

function get_flexible_content() {
	if ( have_rows( 'js_flexible_content' ) && is_singular() ) {
		while ( have_rows( 'js_flexible_content' ) ) {
			the_row();
			get_template_part( 'template-parts/' . get_row_layout() );
		}
	}
}


// Renders links
function get_links_output( $links ) {
	$links_output = '';
	if ( ! empty( $links ) ) {
		$links_output = '<div class="links-wrapper">';
		foreach ( $links as $link ) {
			$links_output .= sprintf( '<a href="%s">%s</a>', $link['link_url'], $link['link_text'] );
		}
		$links_output .= '</div>';
	}

	return $links_output;
}

// Register custom widget areas
function register_custom_widget_area() {
	register_sidebar(
		array(
			'id' => 'contact-info-widget-area',
			'name' => esc_html__( 'Contact info widget area', 'understrap-child' ),
			'description' => esc_html__( 'A new widget area made for displaying contact info', 'understrap-child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
			'after_title' => '</h3></div>'
		)
	);

	register_sidebar(
		array(
			'id' => 'recent-posts-widget-area',
			'name' => esc_html__( 'Recent posts widget area', 'understrap-child' ),
			'description' => esc_html__( 'A new widget area made for displaying recent posts', 'understrap-child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
			'after_title' => '</h3></div>'
		)
	);

	register_sidebar(
		array(
			'id' => 'our-stories-widget-area',
			'name' => esc_html__( 'Our stories widget area', 'understrap-child' ),
			'description' => esc_html__( 'A new widget area made for displaying our stories', 'understrap-child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
			'after_title' => '</h3></div>'
		)
	);

	register_sidebar(
		array(
			'id' => 'useful-links-widget-area',
			'name' => esc_html__( 'Useful links widget area', 'understrap-child' ),
			'description' => esc_html__( 'A new widget area made for displaying useful links', 'understrap-child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
			'after_title' => '</h3></div>'
		)
	);
}
add_action( 'widgets_init', 'register_custom_widget_area' );
