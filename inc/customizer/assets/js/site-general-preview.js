/**
 * File site-general-preview.js.
 *
 * Customize preview for site general
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '#site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			$( 'body.custom-background' ).css( 'background-color', to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '#site-title a, #site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '#site-title a, #site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '#site-title a, #site-title, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );