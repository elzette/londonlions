<?php
/**
 * London Lions.
 *
 * @package      londonlions
 * @author       Semblance
 */

// * This file contains search form improvements
require get_stylesheet_directory() . '/includes/class-search-form.php';

add_action( 'genesis_setup', 'londonlions_setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function londonlions_setup() {

	// * Add HTML5 markup structure
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	add_theme_support( 'genesis-connect-woocommerce' );

	// * Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// * Add support for custom background
	add_theme_support( 'custom-background', array(
		'wp-head-callback' => '__return_false',
	) );

	// * Add support for structural wraps (all default Genesis wraps unless noted)
	add_theme_support(
		'genesis-structural-wraps',
		array(
			'footer',
			'footer-widgets',
			'footernav', // Custom.
			'menu-footer', // Custom.
			'header',
			'home-gallery', // Custom.
			'nav',
			'site-inner',
			'site-tagline',
		)
	);

	// * Add support for two navigation areas (theme doesn't use secondary navigation)
	add_theme_support(
		'genesis-menus',
		array(
			'primary'   => __( 'Primary Navigation Menu', 'londonlions' ),
			'footer'    => __( 'Footer Navigation Menu', 'londonlions' ),
		)
	);

	// * Remove header widget
	unregister_sidebar( 'header-right' );

	// * Move navigation IN header
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav' );

	// * Add custom image sizes
	add_image_size( 'feature-large', 900, 500, true );
	add_image_size( 'timeline', 320, 220, true );

	// * Unregister layouts that use secondary sidebar
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// * Register the default widget areas
	londonlions_register_widget_areas();

	add_action( 'get_header', 'child_sidebar_logic' );

	// * Add featured image above posts
	add_action( 'genesis_after_header', 'll_entry_background' );

	// * Remove the post meta function
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	// * Remove Genesis archive pagination (Genesis pagination settings still apply)
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

	// * Add WordPress archive pagination (accessibility)
	add_action( 'genesis_after_endwhile', 'utility_pro_post_pagination' );

	// * Load accesibility components if the Genesis Accessible plugin is not active
	if ( ! utility_pro_genesis_accessible_is_active() ) {
		// * Load skip links (accessibility)
		include get_stylesheet_directory() . '/includes/skip-links.php';
	}

	// * Apply search form enhancements (accessibility)
	add_filter( 'get_search_form', 'utility_pro_get_search_form', 25 );

	// * WooCommerce actions and filters
	add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'll_add_to_cart_text', 15 );
	add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

	// * Move WooCommerce price
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
}

add_action( 'genesis_after_entry', 'll_set_background_image' );
/**
 * Localize backstretch script
 */
function ll_set_background_image() {
	if ( is_singular( 'post' ) ||  is_singular( 'page' ) ) {
		$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array(
			'format' => 'url',
			 'size' => 'feature-large',
		) ) : '' );
		wp_localize_script( 'll-backstretch-set', 'BackStretchImg', $image );
	}
}

/**
 * Hook entry background area
 */
function ll_entry_background() {
	if ( is_singular( 'post' ) || ( is_singular( 'page' ) && has_post_thumbnail() ) ) {
		echo '<div class="background-wrap">';
		echo '<div class="entry-background"></div>';
		echo '</div>';
	}
}

/**
 * Add News sidebar to single pages
 *
 * @author Jennifer Baumann
 * @link http://dreamwhisperdesigns.com/?p=1034
 */
function child_sidebar_logic() {
	if ( is_singular( 'post' ) || is_archive() ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
			add_action( 'genesis_after_content', 'child_get_alt_sidebar' );
	}
}

/**
 * Retrieve blog sidebar
 */
function child_get_alt_sidebar() {
	get_sidebar( 'alt' );
}

/** Customize Read More Text */
add_filter( 'excerpt_more', 'child_read_more_link' );
add_filter( 'get_the_content_more_link', 'child_read_more_link' );
add_filter( 'the_content_more_link', 'child_read_more_link' );

/**
 * Custom read more link
 */
function child_read_more_link() {
	return '... <a href="' . get_permalink() . '" rel="nofollow">Read full article ></a>';
}

add_filter( 'genesis_footer_creds_text', 'll_footer_creds' );
/**
 * Custom read more link
 *
 * @param type $creds Return custom footer text.
 */
function ll_footer_creds( $creds ) {
	return '&copy;' . date( 'Y' ) . ' LMLFC. All rights reserved. <a href="' . get_bloginfo( 'url' ) . '/privacy-policy-cookies" >Privacy Policy & Cookies</a>  |  <a href="' . get_bloginfo( 'url' ) . '/info/contact-us/" >Contact Us</a>  |  <a href="' . get_bloginfo( 'url' ) .'/wp-admin" >Admin</a>  |  <a href="' . get_bloginfo( 'url' ) . '/community/sponsors/" >Become a sponsor</a>';
}

add_filter( 'genesis_author_box_gravatar_size', 'll_author_box_gravatar_size' );
/**
 * Customize the Gravatar size in the author box.
 *
 * @since 1.0.0
 *
 * @return integer Pixel size of gravatar.
 */
function ll_author_box_gravatar_size( $size ) {
	return 96;
}

// * Add theme widget areas
include get_stylesheet_directory() . '/includes/widget-areas.php';

// * Add scripts to enqueue
include get_stylesheet_directory() . '/includes/enqueue-assets.php';

// * Miscellaenous functions used in theme configuration
include get_stylesheet_directory() . '/includes/theme-config.php';


/***** WOOCOMMERCE FUNCTIONS *****/

/**
 * Remove review tab.
 */
function wcs_woo_remove_reviews_tab( $tabs ) {
	unset( $tabs['reviews'] );
	return $tabs;
}

/**
 * Change 'add to cart' text on single product page.
 */
function ll_add_to_cart_text() {
	return __( 'Sign Up!', 'club/2016-17-junior-trials-registration' );
}

/**
 * Redirect users after add to cart.
 */
function my_custom_add_to_cart_redirect( $url ) {
	$url = WC()->cart->get_checkout_url();
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect' );

// * Remove SKU from single product page
add_filter( 'wc_product_sku_enabled', '__return_false' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/**
 * Add headers to CSV Export.
 *
 * @param type $headers Return header for exporting fields.
 */
function wacf_export_customers_headers( $headers ) {
	$logger = new WC_Logger();
	if ( ! function_exists( 'wacf_get_checkout_field_groups' ) ) {
		return $headers;
	}
	$custom_fields = array();
	$checkout_groups = wacf_get_checkout_field_groups();

	foreach ( $checkout_groups as $post ) {
		$group_fields = get_post_meta( $post->ID, '_checkout_fields', true );

		$billing_fields = array_keys( $group_fields['billing'] );
		// $shipping_fields = array_keys( $group_fields['shipping'] );
		// $order_fields = array_keys( $group_fields['order'] );

		$custom_fields = array_merge( $custom_fields, array_combine( $billing_fields, $billing_fields ) );
		// $custom_fields = array_merge( $custom_fields, array_combine( $shipping_fields, $shipping_fields ) );
		// $custom_fields = array_merge( $custom_fields, array_combine( $order_fields, $order_fields ) );
	}

	foreach ( $custom_fields as $k => $field ) {
		if ( isset( $headers[ $k ] ) ) {
			continue;
		} else {
			$headers[ $k ] = $k;
		}
	}
	return $headers;
}
add_filter( 'wc_customer_order_csv_export_order_headers', 'wacf_export_customers_headers' );

/**
 * Export single line data.
 */
function wacf_export_customers_single_line_data( $order_data, $order, $this ) {
	if ( ! function_exists( 'wacf_get_checkout_field_groups' ) ) {
		return $order_data;
	}
	$custom_fields = array();
	$checkout_groups = wacf_get_checkout_field_groups();
	foreach ( $checkout_groups as $post ) {
		$group_fields           = get_post_meta( $post->ID, '_checkout_fields', true );

// * $custom_fields = array_merge( $custom_fields, $group_fields['shipping'] );
		$custom_fields  = array_merge( $custom_fields, $group_fields['billing'] );

// * $custom_fields  = array_merge( $custom_fields, $group_fields['order'] );
	}

	foreach ( $custom_fields as $k => $field ) {
		if ( isset( $order_data[ $k ] ) ) {
			continue;
		} else {
			$one = get_post_meta( $order->id, $k, true );
			$two = get_post_meta( $order->id, '_' . $k, true );
			$value = empty( $one ) ? $two : $one;
			$order_data[ $k ] = $value;
		}
	}
	return $order_data;
}
add_filter( 'wc_customer_order_csv_export_order_row', 'wacf_export_customers_single_line_data', 10, 3 );

/***** OTHER *****/

add_filter( 'genesis_edit_post_link' , '__return_false' );
/**
 * Remove link to media.
 */
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ( 'none' !== $image_set ) {
			update_option('image_default_link_type', 'none');
	}
}

/**
 * Login logo.
 */
function custom_loginlogo() {
echo '<style type="text/css">
#login h1 a {background-image: url( '.get_bloginfo( 'stylesheet_directory').'/images/login_logo.png) !important; }
</style>';
}
add_action( 'login_head', 'custom_loginlogo' );
