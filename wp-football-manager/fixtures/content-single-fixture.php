<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Template for a single team content.
*
* Templates are overwritable by copying this file to your (child)-theme/wp-football-manager/teams/.
*
* @author		Jeroen Sormani
* @since		1.0.0
*/
?>

<aside class="sidebar sidebar-primary widget-area" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
	<section class="widget">
		<?php
			$team = $fixture->get_team();
			$_team = new WPFM_Team( $team['id'] );

			$season = get_terms( 'season', array( 'orderby' => 'slug', 'order' => 'ASC' ) );
			$season = end( $season );
		?>
		<header class="entry-header" itemprop="headline">
			<h1 class="entry-title"><?php echo $_team->get_team_name(); ?></h1>
			<h2>Fixture</h2>
		</header>
	</section><!-- .widget -->
	<section class="widget">
		<ul class="team-submenu">

			<li><a href='<?php echo get_permalink( $team['id'] ); ?>'><?php _e( 'View Team', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( $team['id'] ) . 'results/' . $season->slug; ?>'><?php _e( 'View Fixtures', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( $team['id'] ) . 'stats/' . $season->slug; ?>'><?php _e( 'View Statistics', 'wp-football-manager' ); ?></a></li>
		</ul>
	</section><!-- .widget -->

	<section class="widget">
		<div class="team-meta">
			<p><b>Manager:</b> <?php the_field('team_manager', $_team->id); ?></p>
			<p><b>Assistant Manager:</b> <?php the_field('team_assistant_manager', $_team->id); ?></p>
			<p><b>Coach:</b> <?php the_field('team_coach', $_team->id); ?></p>
			<p><b>Physio:</b> <?php the_field('team_physio', $_team->id); ?></p>
		</div><!-- .team-meta -->
		<div class="sponsor-container"><b>Team sponsor</b><br><div class="sponsor-box"><?php the_field('team_sponsor', $_team->id); ?></div></div>
	</section><!-- .widget -->

</aside><!-- .sidebar -->

<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>

	<h2 class="entry-title"><?php the_title(); ?></h2>

	<div class="entry-content team-content" itemprop="text">

		<div class='fixture-details'>

			<table>
				<tbody>

					<tr>
						<th><?php _e( 'Date', 'wp-football-maanger' ); ?></th>
						<td><?php echo date( get_option( 'date_format', 'd-m-Y' ), $fixture->match_date ); ?></td>
					</tr>
					<tr>
						<th><?php _e( 'Home/Away', 'wp-football-maanger' ); ?></th>
						<td><?php
							if ( 'away' == $fixture->location ) :
								_e( 'Away', 'wp-football-manager' );
							elseif ( 'home' == $fixture->location ) :
								_e( 'Home', 'wp-football-manager' );
							endif;
						?></td>
					</tr><?Php

					if ( ! empty( $fixture->competition_id ) ) :
						?><tr>
							<th><?php _e( 'Competition', 'wp-football-maanger' ); ?></th>
							<td><?php echo $fixture->get_competition(); ?></td>
						</tr><?php
					endif;

					if ( ! empty( $fixture->season_id ) ) :
						?><tr>
							<th><?php _e( 'Season', 'wp-football-maanger' ); ?></th>
							<td><?php echo $fixture->get_season(); ?></td>
						</tr><?php
					endif;

					?><tr>
						<th><?php _e( 'Kick-off Time', 'wp-football-maanger' ); ?></th>
						<td><?php echo date( get_option( 'time_format', 'H:i' ), strtotime( $fixture->kickoff ) ); ?></td>
					</tr>
					<tr class="result-row">
						<th><?php _e( 'Result', 'wp-football-maanger' ); ?></th>
						<td><?php echo $fixture->get_formatted_result(); ?></td>
					</tr>

				</tbody>
			</table>

		</div>


		<div class='fixture-report'>

			<h3><?php _e( 'Match report', 'wp-football-manager' ); ?></h3><?php

			the_content();

		?></div>


		<div class='fixture-stats'>

			<h3><?php _e( 'Squad Statistics', 'wp-football-manager' ); ?></h3>

			<table>
				<thead>
					<th><?php _e( '', 'wp-football-manager' ); ?></th>
					<th><?php _e( 'Name', 'wp-football-manager' ); ?></th>
					<th class="number"><?php _e( 'Goals', 'wp-football-manager' ); ?></th>
				</thead>

				<tbody><?php

					$i = 0;
					if ( $players = $fixture->get_players() ) :
						foreach ( $players as $player ) :

							$i++;
							?><tr class='<?php echo $fixture->mom_id == $player['user_id'] ? 'mom' : ''; ?>'>
								<td class="number"><?php echo $i; ?></td>
								<td><?php echo $player['full_name']; ?></td>
								<td class="number"><?php
									echo $player['goals'];

									if ( $fixture->mom_id == $player['user_id'] ) :
										?><span class='mom-badge'>MOM</span><?php
									endif;
								?></td>
							</tr><?php

						endforeach;
					endif;
				?></tbody>
			</table>

		</div>

	</div><!-- .entry-content -->

</article><!-- #post -->
