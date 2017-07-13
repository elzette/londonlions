<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Template for a player profile content.
 *
 * Templates are overwritable by copying this file to your (child)-theme/wp-football-manager/players/.
 *
 * @author		Jeroen Sormani
 * @since		1.0.0
 */

$team_id 	= $player->get_team();
$team 		= new WPFM_Team( $team_id );

$season = get_terms( 'season', array( 'orderby' => 'slug', 'order' => 'ASC' ) );
$season = end( $season );

?>

<aside class="sidebar sidebar-primary widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<section class="widget">
		<header class="entry-header" itemprop="headline">
			<h1 class="entry-title">Player Profile</h1>
		</header>
	</section><!-- .widget -->
	<section class="widget">
		<ul class="team-submenu">
			<li><a href='<?php echo get_permalink( $team->id ); ?>'><?php _e( 'View Team', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( $team->id ) . 'results/' . $season->slug; ?>'><?php _e( 'View Fixtures', 'wp-football-manager' ); ?></a></li>
			<li><a href='<?php echo get_permalink( $team->id ) . 'stats/' . $season->slug; ?>'><?php _e( 'View Statistics', 'wp-football-manager' ); ?></a></li>
		</ul>
	</section><!-- .widget -->
	
</aside><!-- .sidebar -->

<article id="player-<?php $player->id; ?>" <?php post_class(); ?>>

	<header class="entry-header" itemprop="headline">
		<h1 class="entry-title"><?php echo $player->full_name; ?></h1>
	</header>

	<div class="entry-content player-profile-content" itemprop="text">

		<div class='player-image'><?php
			$image_src = $player->get_image_src();
			if ( $image_src[0] ) :
				?><img src='<?php echo $image_src[0]; ?>' class='player-profile-image'><?php
			endif;
		?></div>

		<div class='player-details-table-wrapper'>
			<table class='player-details'>
				<tbody>
					<tr>
						<th><?php _e( 'Name', 'wp-football-manager' ); ?></th>
						<td><?php echo $player->full_name; ?></td>
					</tr>
					<tr class="dob">
						<th><?php _e( 'Date of birth', 'wp-football-manager' ); ?></th>
						<td><?php echo $player->get_formatted_birthday(); ?></td>
					</tr>
					<tr>
						<th><?php _e( 'Team', 'wp-football-manager' ); ?></th>
						<td><?php echo $team->get_team_name(); ?></td>
					</tr>
					<tr>
						<th><?php _e( 'Total goals', 'wp-football-manager' ); ?></th>
						<td><?php echo $player->goals; ?></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div><!-- .entry-content -->

</article><!-- #post -->
