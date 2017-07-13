<?php

add_action( 'wp_enqueue_scripts', 'll_enqueue_assets' );

function ll_enqueue_assets() {

	wp_enqueue_style( 'll-google-fonts', 'http://fonts.googleapis.com/css?family=Enriqueta:400,700|Open Sans:400,700', false );

	// Load mobile responsive menu
	wp_enqueue_script( 'll-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Keyboard navigation (dropdown menus) script
	wp_enqueue_script( 'genwpacc-dropdown',  get_stylesheet_directory_uri() . '/js/genwpacc-dropdown.js', array( 'jquery' ), false, true );
	
	wp_enqueue_script( 'llscript',  get_stylesheet_directory_uri() . '/js/llscripts.js', array( 'jquery' ), '1.2.8', false );
	
	if ( is_singular( array( 'post', 'page' ) ) && has_post_thumbnail() ) {	
		wp_enqueue_script( 'll-backstretch', get_stylesheet_directory_uri() . '/js/jquery.backstretch.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'll-backstretch-set', get_stylesheet_directory_uri() . '/js/backstretch-set.js' , array( 'jquery', 'll-backstretch' ), '1.1', true );
	}
	// Load skiplink scripts only if Genesis Accessible plugin is not active
	if ( ! utility_pro_genesis_accessible_is_active() ) {
		wp_enqueue_script( 'genwpacc-skiplinks-js',  get_stylesheet_directory_uri() . '/js/genwpacc-skiplinks.js', array(), '1.0.0', true );
	}

}
