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
			<h2>Team Results</h2>
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

	<div class="entry-content team-content">

		<div class='switch-seasons'>
			<form method='post' action='<?php echo get_permalink( get_the_ID() ) . 'results/'; ?>'>
				<select name='season' id='team-stats-season'><?php
					foreach ( get_terms( 'season', array( 'hide_empty' => false, 'order' => 'DESC' ) ) as $term ) :
						?><option value='<?php echo $term->slug; ?>' <?php selected( $term->slug, $season->slug ); ?>><?php echo esc_html( $term->name ); ?></option><?php
					endforeach;
				?></select>
			</form>
		</div>

		<div class='fixtures'>

			<table>
				<thead>
					<th><?php _e( 'Date', 'wp-football-manager' ); ?></th>
					<th><?php _e( 'Opposition', 'wp-football-manager' ); ?></th>
					<th class="col-center no-mobile home-away"><?php _e( 'H/A', 'wp-football-manager' ); ?></th>
					<th class="no-mobile"><?php _e( 'Competition', 'wp-football-manager' ); ?></th>
					<th class="col-center result"><?php _e( 'Result', 'wp-football-manager' ); ?></th>
					<th class="no-mobile col-center view"><?php _e( 'View', 'wp-football-manager' ); ?></th>
				</thead>

				<tbody><?php
					if ( $fixtures ) :
						foreach ( $fixtures as $fixture ) :

							$_fixture = new WPFM_Fixture( $fixture->ID );
							?><tr>
								<td><a href='<?php echo get_permalink( $fixture->ID ); ?>'><?php echo date( 'd-m-Y', strtotime( $_fixture->get_match_date() ) ); ?></td>
								<td><a href='<?php echo get_permalink( $fixture->ID ); ?>'><?php echo $_fixture->opposition; ?></td>
								<td class="col-center no-mobile home-away"><a href='<?php echo get_permalink( $fixture->ID ); ?>'><?php echo ucfirst( $_fixture->location ); ?></td>
								<td class="no-mobile"><a href='<?php echo get_permalink( $fixture->ID ); ?>'><?php echo $_fixture->get_competition(); ?></td>
								<td class="col-center result"><a href='<?php echo get_permalink( $fixture->ID ); ?>'><?php echo $_fixture->get_formatted_result(); ?></td>
								<td class="no-mobile col-center view-more"><a href='<?php echo get_permalink( $fixture->ID ); ?>'><?php _e( 'More', 'wp-football-manager' ); ?></td>
							</tr><?php

						endforeach;
					else :
						?><tr><td colspan='6'><?php _e( 'There are no matches played yet in this season', 'wp-football-manager' ); ?></td></tr><?php
					endif;
				?></tbody>
			</table>

		</div><!-- .entry-fixturs -->

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