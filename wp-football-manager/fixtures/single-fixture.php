<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Template for a single fixture.
 *
 * Templates are overwritable by copying this file to your (child)-theme/wp-football-manager/fixtures/.
 *
 * @author		Jeroen Sormani
 * @since		1.0.0
 */

add_action( 'genesis_meta', 'll_single_fixture_template' );

function ll_single_fixture_template() {

	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_after_header', 'll_team_entry_background' );
	add_action( 'genesis_before_loop', 'll_add_single_fixture_content' );
	add_action( 'genesis_after_header', 'change_to_senior_teams_sidebar' );
}

//* Hook entry background area
function ll_team_entry_background() {

	$fixture = new WPFM_Fixture( get_the_ID() );
	$team = $fixture->get_team();
	
	$teamimage = get_field('team_featured_image', $team['id']);
	echo '<div class="background-wrap">';
	echo '<div class="entry-background" alt="' . $teamimage['alt'] . '" style="background-image: url(' . $teamimage['sizes']['feature-large'] . '); background-position: center;"></div>';
	echo '</div>';
}

function ll_add_single_fixture_content() {

	while ( have_posts() ) : the_post();
		wpfm_get_template( 'fixtures/content-single-fixture.php', array( 'fixture' => new WPFM_Fixture( get_the_ID() ) ) );
	endwhile;
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
