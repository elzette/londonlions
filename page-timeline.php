<?php
/**
 * London Lions.
 *
 * @package londonlions
 * @author Semblance
 *
 * Template Name: Timeline
 */

add_action( 'genesis_meta', 'll_timeline_setup' );
/**
 * Set up the homepage layout by conditionally loading sections when widgets
 * are active.
 */
function ll_timeline_setup() {
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
	add_action( 'genesis_entry_content', 'll_timeline_section' );
}

/**
 * Display ACF Timeline in Page Template.
 */
function ll_timeline_section() {
	echo '<header class="entry-header" itemprop="headline">';
	echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
	echo '</header>';

	$rows = get_field( 'timeline' );
	if ( $rows ) {
		echo '<table class="timeline">';

		// * First row of table to make the top upwards arrow of timeline
		echo '<tr><td class="arrow-left"></td><td class="arrow-right"></td></tr>';

		// * Setup of rest of timeline to make each entry a row in the table structure
		foreach( $rows as $row ) {
			echo '<tr><td class="yeardate">' . $row['year'] . '</td>';
			echo '<td class="event-entry"><b>' . $row['timeline_entry_title'] . '</b>';

			// Using the ACF Image ID with new image size set in function.php called 'timeline'
			$timeimage = wp_get_attachment_image_src( $row['timeline_photo'], 'timeline' );
			if ( $timeimage ) {
				echo '<img src="' . $timeimage[0] . '">';
			}
			echo '<br>' . $row['timeline_entry_description'] . '</td></tr>';
		}
		echo '</table>';
	}
}

genesis();
