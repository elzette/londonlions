(function( $ ) {

$( window ).load( function() { // Add js below to be loaded after everything else has loaded (in theory)

	// Leveling main and aside elements
	var mainHeight = $( '.home main' ).height(),
		wrapHeight = $( '.home .site-inner .wrap' ).height(),
		innerHeight = $( '.home .site-inner' ).height(),
		mainTeamHeight = $( '.team-landing main' ).height(),
		wrapTeamHeight = $( '.team-landing .site-inner .wrap' ).height(),
		innerTeamHeight = $( '.team-landing .site-inner' ).height(),
		ww = document.body.clientWidth;

	if (ww >= 1025) {
		$( '.home aside' ).height( mainHeight + 352 );
		$( '.home .site-inner .wrap' ).height( wrapHeight );
		$( '.home .site-inner' ).height( wrapHeight + 120 );
		$( '.home .site-container' ).height( wrapHeight );
		$( 'html' ).height( wrapHeight );
		$( '.team-landing aside' ).height( mainTeamHeight + 352 );
		$( '.team-landing .site-inner .wrap' ).height( mainTeamHeight + 60 );
		$( '.team-landing .site-inner' ).height( mainTeamHeight + 120 );
		$( '.team-landing .site-container' ).height( mainTeamHeight );
		$( 'html' ).height( mainTeamHeight );
	}
	if (ww < 1025) {
		$( '.no-mobile' ).css( 'display','none' );
	}

	// Add angle image bar before content
	$( '<figure class="content-top" style="background-image: url(//www.londonlions.com/wp-content/themes/londonlions/images/content-top.svg); background-size: 100%;"></figure>' ).prependTo( '.site-inner' );

	// Add toggle to Juniors sub nav
	$( '#menu-junior-teams-sub-menu .sub-menu' ).hide(); //Hide children by default
	$( '#menu-junior-teams-sub-menu' ).children().click( function(e) {
		e.preventDefault();
    	$( this ).children( '#menu-junior-teams-sub-menu .sub-menu' ).slideToggle( 'slow' );
    	if ($( '#menu-junior-teams-sub-menu .sub-menu' ).is( ':visible' ) ) {
			$( this ).toggleClass( 'open-sub' );
		}
	}).children( '#menu-junior-teams-sub-menu .sub-menu' ).click( function( event ) {
    	event.stopPropagation();
	});

	// Add toggle to Developing teams sub nav
	$( '#menu-developing-teams .sub-menu' ).hide(); //Hide children by default
	$( '#menu-developing-teams' ).children().click( function(e) {
		e.preventDefault();
    	$( this ).children( '#menu-developing-teams .sub-menu' ).slideToggle( 'slow' );
    	if ( $( '#menu-developing-teams .sub-menu' ).is( ':visible' ) ) {
			$( this ).toggleClass( 'open-dev-sub' );
		}
	}).children( '#menu-developing-teams .sub-menu' ).click( function ( event ) {
    	event.stopPropagation();
	});

	// Add column classes
	$( '.home .entry section:nth-child(2n)' ).addClass( 'last_column' );
	$( '.home .entry .news-widget p:last-child' ).addClass( 'last_row' );
	$( '.page-template-page-team-landing .home-news section:nth-child(2n)' )
		.addClass( 'last_column' );
});

})( jQuery );
