<?php
/**
 * London Lions.
 *
 * @package      londonlions
 * @author       Semblance
 *
 * Template Name: Team Landing
 */

add_action( 'genesis_meta', 'll_team_landing_setup' );
/**
 * Set up the homepage layout by conditionally loading sections when widgets
 * are active.
 */
function ll_team_landing_setup() {
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	add_action( 'genesis_loop', 'll_team_news_section' );
	remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
	add_action( 'genesis_before_content', 'genesis_get_sidebar' );
}

/**
 * Display news section on home page
 */
function ll_team_news_section() {
	echo '<article class="entry">';
	echo '<h2>Latest</h2>';
	$rows = get_field( 'team_news_entries' );
	if ( $rows ) {
		echo '<div class="home-news">';
		foreach ( $rows as $row ) {
			echo '<section><div class="news-widget">' . $row['team_news_entry'] . '</div></section>';
		}
		echo '</div>';
	}
}

genesis();
