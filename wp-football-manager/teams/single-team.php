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
add_action( 'genesis_meta', 'll_single_team_template' );

function ll_single_team_template() {

	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_after_header', 'll_team_entry_background' );
	add_action( 'genesis_before_loop', 'll_add_single_team_content' );
}

//* Hook entry background area
function ll_team_entry_background() {
	$teamimage = get_field('team_featured_image');
	echo '<div class="background-wrap">';
	echo '<div class="entry-background" alt="' . $teamimage['alt'] . '" style="background-image: url(' . $teamimage['sizes']['feature-large'] . '); background-position: center;"></div>';
	echo '</div>';
}

function ll_add_single_team_content() {

	$template = get_option( 'template' );


	if ( $season_slug = get_query_var( 'stats', false ) ) :

		$team 				= new WPFM_team( get_the_ID() );
		$season 			= get_term_by( 'slug', $season_slug, 'season' );
		$fixtures			= $team->get_fixtures();
		$season_stats		= $team->get_season_stats( $season->slug );

		wpfm_get_template( 'teams/content-single-team-stats.php', array( 'team' => $team, 'season' => $season, 'season_stats' => $season_stats ) );

	elseif ( $season_slug = get_query_var( 'results', false ) ) :

		$team 				= new WPFM_team( get_the_ID() );
		$season 			= get_term_by( 'slug', $season_slug, 'season' );
		$fixtures			= $team->get_fixtures( array(
			'tax_query' => array(
				array(
					'taxonomy'	=> 'season',
					'field'		=> 'slug',
					'terms'		=> $season_slug,
				),
			),
		) );

		wpfm_get_template( 'teams/content-single-team-results.php', array( 'team' => new WPFM_team( get_the_ID() ), 'season' => $season, 'fixtures' => $fixtures ) );

	else :

		while ( have_posts() ) : the_post();
			$team 			= new WPFM_team( get_the_ID() );
			$last_season 	= get_terms( 'season', array( 'orderby' => 'slug', 'order' => 'ASC' ) );
			$last_season 	= end( $last_season );
			$fixtures		= $team->get_fixtures();
			wpfm_get_template( 'teams/content-single-team.php', array( 'team' => new WPFM_team( get_the_ID() ), 'season' => $last_season, 'fixtures' => $fixtures ) );
		endwhile;

	endif;

}

//* To remove empty markup, '<p class="entry-meta"></p>' for entries that have not been assigned to any Genre
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


genesis();
