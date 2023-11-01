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
	// Otherwise, add search form.
	$items .= '<li class="menu-item search-form-trigger">' . get_search_form( false ) . '</li>';
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


// Mega menu

// Add a custom field to menu item
function add_menu_item_checkbox_field( $item_id, $item ) {
	?>
  <p class="field-checkbox description description-wide">
    <label>
      <input type="checkbox" class="menu-item-checkbox" name="menu-item-checkbox[<?php echo esc_attr( $item_id ); ?>]"
             value="1" <?php checked( '1', get_post_meta( $item_id, '_menu_item_checkbox', true ) ); ?> />
      Is mega menu
    </label>
  </p>
	<?php
}

add_action( 'wp_nav_menu_item_custom_fields', 'add_menu_item_checkbox_field', 10, 2 );

// Save the custom field data
function save_menu_item_checkbox_field( $menu_id, $menu_item_db_id, $menu_item_args ) {
	if ( isset( $_POST['menu-item-checkbox'][ $menu_item_db_id ] ) ) {
		update_post_meta( $menu_item_db_id, '_menu_item_checkbox', '1' );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_checkbox' );
	}
}

add_action( 'wp_update_nav_menu_item', 'save_menu_item_checkbox_field', 10, 3 );


// Display the checkbox in the menu item
function display_menu_item_checkbox( $item_output, $item ) {
	if ( '1' == get_post_meta( $item->ID, '_menu_item_checkbox', true ) ) {
		$item_output = '<label><input type="checkbox" checked> ' . $item_output . '</label>';
	}

	return $item_output;
}

// add_filter( 'walker_nav_menu_start_el', 'display_menu_item_checkbox', 10, 2 );


// Mega menu menu selection
// Add a custom field for selecting a menu
function add_menu_item_select_field( $item_id, $item ) {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	?>
  <p class="field-select description description-wide">
    <label for="menu-item-select-<?php echo esc_attr( $item_id ); ?>">Select Menu:</label>
    <select id="menu-item-select-<?php echo esc_attr( $item_id ); ?>"
            name="menu-item-select[<?php echo esc_attr( $item_id ); ?>]">
      <option value="">Select a menu</option>
		<?php foreach ( $menus as $menu ) : ?>
          <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $menu->term_id, get_post_meta( $item_id, '_menu_item_select', true ) ); ?>><?php echo esc_html( $menu->name ); ?></option>
		<?php endforeach; ?>
    </select>
  </p>
	<?php
}

add_action( 'wp_nav_menu_item_custom_fields', 'add_menu_item_select_field', 10, 2 );

// Save the custom field data
function save_menu_item_select_field( $menu_id, $menu_item_db_id, $menu_item_args ) {
	if ( isset( $_POST['menu-item-select'][ $menu_item_db_id ] ) ) {
		update_post_meta( $menu_item_db_id, '_menu_item_select', (int) $_POST['menu-item-select'][ $menu_item_db_id ] );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_select' );
	}
}

add_action( 'wp_update_nav_menu_item', 'save_menu_item_select_field', 10, 3 );

// Display the selected menu in the menu item
function display_menu_item_select( $item_output, $item ) {
	$selected_menu_id = get_post_meta( $item->ID, '_menu_item_select', true );
	if ( $selected_menu_id ) {
		$menu_args     = array(
			'menu'            => $selected_menu_id,
			'container'       => 'div',
			'container_class' => 'menu-container',
		);
		$selected_menu = wp_nav_menu( $menu_args );
		$item_output   = $selected_menu . $item_output;
	}

	return $item_output;
}

// add_filter( 'walker_nav_menu_start_el', 'display_menu_item_select', 10, 2 );
