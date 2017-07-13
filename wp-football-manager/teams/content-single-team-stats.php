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
<aside class="sidebar sidebar-primary widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<section class="widget">
		<header class="entry-header" itemprop="headline">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<h2>Team Statistics</h2>
		</header>
	</section><!-- .widget -->
	<section class="widget">
		<ul class="team-submenu">
			<li><a href='<?php echo get_permalink( get_the_ID() ); ?>'><?php _e( 'View Team', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( get_the_ID() ) . 'results/' . $season->slug; ?>'><?php _e( 'View Fixtures', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( get_the_ID() ) . 'stats/' . $season->slug; ?>'><?php _e( 'View Statistics', 'wp-football-manager' ); ?></a></li>
		</ul>
	</section><!-- .widget -->
	<section class="widget">
		<div class="team-meta">
			<p><b>Manager:</b> <?php the_field('team_manager'); ?></p>
			<p><b>Assistant Manager:</b> <?php the_field('team_assistant_manager'); ?></p>
			<p><b>Coach:</b> <?php the_field('team_coach'); ?></p>
			<p><b>Physio:</b> <?php the_field('team_physio'); ?></p>
		</div><!-- .team-meta -->
		<div class="sponsor-container"><b>Page Sponsor</b><br><div class="sponsor-box"><?php the_field('team_sponsor'); ?></div></div>
	</section><!-- .widget -->
</aside><!-- .sidebar -->

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content team-content" itemprop="text">

		<div class='switch-seasons'>
			<form method='post' action='<?php echo get_permalink( get_the_ID() ) . 'stats/'; ?>'>
				<select name='season' id='team-stats-season'><?php
					foreach ( get_terms( 'season', array( 'hide_empty' => false, 'order' => 'DESC' ) ) as $term ) :
						?><option value='<?php echo $term->slug; ?>' <?php selected( $term->slug, $season->slug ); ?>><?php echo esc_html( $term->name ); ?></option><?php
					endforeach;
				?></select>
			</form>
		</div>

		<div class='fixtures'><?php

			if ( $season_stats ) :
				?><table>
					<thead>
						<th><?php _e( '', 'wp-football-manager' ); ?></th>
						<th class="col-center"><?php _e( 'Matches', 'wp-football-manager' ); ?></th>
						<th class="col-center"><?php _e( 'Goals', 'wp-football-manager' ); ?></th>
						<th class="col-center"><?php _e( 'MoM', 'wp-football-manager' ); ?></th>
					</thead>
					<tbody><?php
						function wpfm_sort_by_matches( $a, $b ) {
						    return $a['matches'] - $b['matches'];
						}
						usort( $season_stats, 'wpfm_sort_by_matches' );
						$season_stats = array_reverse( $season_stats );
						foreach ( $season_stats as $stat ) :
							?><tr>
								<td class="player-link"><a href='<?php echo get_player_profile_link( $stat['user_id'] ); ?>'><?php echo $stat['full_name']; ?></a></td>
								<td class="col-center"><?php echo $stat['matches']; ?></td>
								<td class="col-center"><?php echo $stat['goals']; ?></td>
								<td class="col-center"><?php echo $stat['mom']; ?></td>
							</tr><?php
						endforeach;
					?></tbody>
				</table><?php

			else :
				?><p><?php _e( 'There are no statistics available for this season', 'wp-football-manager' ); ?></p><?php
			endif;

		?></div>

	</div><!-- .entry-content -->

</article><!-- #post -->

<script>
	jQuery( document ).ready( function( $ ) {
		$( '#team-stats-season' ).on( 'change', function() {
			$form = $( this ).closest( 'form' );
			$form.attr( 'action', $form.attr( 'action' ) + $( this ).val() );
			$form.submit();
		});
	});
</script>