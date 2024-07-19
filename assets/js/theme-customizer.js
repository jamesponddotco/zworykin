/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {

	// Site Name
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.site-name' ).text( newval );
		} );
	} );

	// Background color
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site-nav, .site-nav footer' ).css( 'background', newval );
		} );
	} );

	// Alt Nav
	wp.customize( 'zworykin_alt_nav', function( value ) {
		value.bind( function( newval ) {
			console.log( newval );
			if ( newval == true ) {
				$( 'body' ).addClass( 'show-alt-nav' );
			} else {
				$( 'body' ).removeClass( 'show-alt-nav' );
			}
		} );
	} );

} )( jQuery );
