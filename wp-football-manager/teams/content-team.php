<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Template for team content.
*
* This is seen at the team archive page.
* Templates are overwritable by copying this file to your (child)-theme/wp-football-manager/teams/.
*
* @author		Jeroen Sormani
* @since		1.0.0
*/

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header" itemprop="headline">
		<h1 class="entry-title"><a href='<?php echo get_permalink( get_the_ID() ); ?>'><?php the_title(); ?></a></h1>
	</header>

</article>
