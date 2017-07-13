<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Wrapper start.
 *
 * The initial divs of the custom templates..
 * Templates are overwritable by copying this file to your (child)-theme/wp-football-manager/.
 *
 * @author		Jeroen Sormani
 * @since		1.0.0
 */

$template = get_option( 'template' );

switch( $template ) {
	default :
	case 'twentyeleven' :
	case 'twentytwelve' :
	case 'twentythirteen' :
	case 'twentyfifteen' :
		echo '</div></div>';
		break;
	case 'twentyfourteen' :
		echo '</div></div></div>';
		get_sidebar( 'content' );
		break;
}
