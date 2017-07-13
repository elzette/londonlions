<?php
/**
 * London Lions.
 *
 * @package londonlions
 * @author Semblance
 */
?>

<aside class="sidebar sidebar-primary widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<section class="widget">
		<header class="entry-header" itemprop="headline">
			<h1 class="entry-title">Player Profile</h1>
		</header>
	</section><!-- .widget -->
	<section class="widget">
		<ul class="team-submenu">
			<li><a href='<?php echo get_permalink( get_the_ID() ) . 'results/' . $season->slug; ?>'><?php _e( 'View Fixtures', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( get_the_ID() ) . 'stats/' . $season->slug; ?>'><?php _e( 'View Statistics', 'wp-football-manager' ); ?></a></li>
		</ul>
	</section><!-- .widget -->
	<section class="widget">
		<div class="team-meta">
			<p><b>Manager:</b> <?php the_field( 'team_manager' ); ?></p>
			<p><b>Assistant Manager:</b> <?php the_field( 'team_assistant_manager' ); ?></p>
			<p><b>Coach:</b> <?php the_field( 'team_coach' ); ?></p>
			<p><b>Physio:</b> <?php the_field( 'team_physio' ); ?></p>
		</div><!-- .team-meta -->
		<p class="sponsor"><b>Team sponsor</b><br><?php the_field( 'team_sponsor' ); ?></p>
	</section><!-- .widget -->
</aside><!-- .sidebar -->
