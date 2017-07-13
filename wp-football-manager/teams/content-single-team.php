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
			<h2>Fixtures and Results</h2>
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

<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>

	<div class='entry-content team-content' itemprop="text"><?php

		?><div class='team-players'><?php
			if ( $players = $team->get_players() ) :
				foreach ( $players as $player ) :

					$_player = new WPFM_Player( $player->id );
					?><div class='single-player'>

						<a href='<?php echo get_player_profile_link( $player->id ); ?>'>
							<div class='player-photo'><?php
								if ( $image_src = $_player->get_image_src( array( 100, 100 ) ) ) :
									?><img src='<?php echo $image_src[0]; ?>' width='100'><?php
								else :
									?><img src='<?php echo content_url( 'themes/londonlions/images/no-player-image.png', WP_Football_Manager()->file ); ?>' width='100'><?php
								endif;

							?></div>

							<div class='player-name'><h3><?php echo $_player->full_name; ?></h3></div>
						</a>

					</div><?php

				endforeach;
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