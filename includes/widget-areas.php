<?php

function londonlions_register_widget_areas() {

	$widget_areas = array(
		array(
			'id'          => 'll-home-welcome',
			'name'        => __( 'Home Welcome', 'londonlions' ),
			'description' => __( 'This is the welcome section at the top of the mobile home page.', 'londonlions' ),
		),
		array(
			'id'          => 'utility-call-to-action',
			'name'        => __( 'Home Page Slider', 'londonlions' ),
			'description' => __( 'This is the slider on the home page.', 'londonlions' ),
		),
		array(
			'id'          => 'home-call-to-action',
			'name'        => __( 'Home Call-to-Action', 'londonlions' ),
			'description' => __( 'For the two teams call-to-action buttons on the home page.', 'londonlions' ),
		),
		array(
			'id'          => 'll-home-news',
			'name'        => __( 'Home News', 'londonlions' ),
			'description' => __( 'News widget for the home page.', 'londonlions' ),
		),
		array(
			'id'          => 'll-home-adverts',
			'name'        => __( 'Home Adverts', 'londonlions' ),
			'description' => __( 'Two advert widgets to go on the home page.', 'londonlions' ),
		),

	);

	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}
