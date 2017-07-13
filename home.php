<?php
/**
 * London Lions.
 *
 * @package      londonlions
 * @author       Semblance
 */

add_action( 'genesis_meta', 'londonlions_homepage_setup' );
/**
 * Initialise home page setup.
 */
function londonlions_homepage_setup() {
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	$home_sidebars = array(
		'home_welcome' 	   => is_active_sidebar( 'll-home-welcome' ),
		'call_to_action'   => is_active_sidebar( 'utility-call-to-action' ),
		'll-home-call-to-action'   => is_active_sidebar( 'home-call-to-action' ),
		'home-news'   => is_active_sidebar( 'll-home-news' ),
		'home-adverts'   => is_active_sidebar( 'll-home-adverts' ),
	);

	// * Return early if no sidebars are active
	if ( ! in_array( true, $home_sidebars ) ) {
		return;
	}

	// * Add intro widget for home page on mobile
	if ( is_front_page() ) {
		if ( $home_sidebars['home_welcome'] ) {
			add_action( 'genesis_after_header', 'londonlions_add_home_welcome' );
		}

		// * Add call to action area if "Call to Action" widget area is active
		if ( $home_sidebars['call_to_action'] ) {
			add_action( 'genesis_after_header', 'londonlions_add_call_to_action' );
		}

		// * Add call to action for two team buttons
		if ( $home_sidebars['ll-home-call-to-action'] ) {
			add_action( 'genesis_before_loop', 'two_teams_call_to_action' );
		}

		// * Add news section for home page
		if ( $home_sidebars['home-news'] ) {
			add_action( 'genesis_before_loop', 'home_news_section' );
		}

		// * Add two adverts on home page
		if ( $home_sidebars['home-adverts'] ) {
			add_action( 'genesis_before_loop', 'home_adverts_section' );
		}
	}
}

/**
 * Display content for the "Home Welcome" section.
 */
function londonlions_add_home_welcome() {
	genesis_widget_area( 'll-home-welcome',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}

/**
 * Display content for the "Call to action" section.
 */
function londonlions_add_call_to_action() {
	genesis_widget_area(
		'utility-call-to-action',
		array(
			'before' => '<div class="home-slider">',
			'after' => '</div>',
		)
	);
}

/**
 * Display two teams "Call to action" on home page.
 */
function two_teams_call_to_action() {
	genesis_widget_area(
		'home-call-to-action',
		array(
			'before' => '<div class="home-call-to-action">',
			'after' => '</div>',
		)
	);
}

/**
 * Display news section on home page.
 */
function home_news_section() {
	echo '<article class="entry">';
	echo '<h2>Latest</h2>';
	$rows = get_field( 'home_news_entries' );
	if ( $rows ) {
		echo '<div class="home-news">';
		foreach ( $rows as $row ) {
			echo '<section class="block ' . $row['announcement'] . '"><div class="news-widget">' . $row['home_news_entry'] . '</div></section>';
		}
		echo '</div>';
	}
}

/**
 * Display two adverts on home page.
 */
function home_adverts_section() {
	genesis_widget_area(
		'll-home-adverts',
		array(
			'before' => '<div class="home-adverts">',
			'after' => '</div>',
		)
	);
	echo '</article>';
}


genesis();
