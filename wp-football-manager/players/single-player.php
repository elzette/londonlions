<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Template for a player profile.
 *
 * Templates are overwritable by copying this file to your (child)-theme/wp-football-manager/players/.
 *
 * @author		Jeroen Sormani
 * @since		1.0.0
 */

add_action( 'genesis_meta', 'll_single_player_template' );

function ll_single_player_template() {
	add_filter( 'body_class', 'semb_body_class' );
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_after_header', 'single_fixture_entry_background' );
	add_action( 'genesis_before_loop', 'll_add_single_player_content' );
	add_action( 'genesis_after_header', 'change_to_senior_teams_sidebar' );
}


function semb_body_class( $classes ) {
	
	$classes[] = 'single-player';
	return $classes;
}

//* Hook entry background area
function single_fixture_entry_background() {
		
	echo '<div class="background-wrap">';
	echo '<div class="entry-background" alt="decoration" style="background-image: url(' . get_bloginfo('stylesheet_directory') . '/images/men-featured.jpg); background-position: center;"></div>';
	echo '</div>';
	
}


function ll_add_single_player_content() {

	$player_id 	= get_query_var( 'player', false );
	$player 	= new WPFM_Player( $player_id );

	if ( array_key_exists( 'player', $player->userdata->caps ) ) :

		wpfm_get_template( 'players/content-single-profile.php', array( 'player' => $player ) );

	else :

		?><p><?php _e( 'Could not find player', 'wp-football-manager' ); ?></p><?php

	endif;

}

/**
 * Show Senior Team sidebar in Primary Sidebar location.
 */

function change_to_senior_teams_sidebar() {

	if( is_active_sidebar( 'senior-teams-sidebar' ) ) {
		// Remove the Primary Sidebar from the Primary Sidebar area.
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		add_action( 'genesis_sidebar', 'll_senior_teams_sidebar' );
	}
}

function ll_senior_teams_sidebar() {
	dynamic_sidebar( 'senior-teams-sidebar' );
}

	
//* To remove empty markup, '<p class="entry-meta"></p>' for entries that have not been assigned to any Genre
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


genesis();

