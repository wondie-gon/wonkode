/**
 * File woo-featured-preview.js.
 *
 * Customize preview for WooCommerce featured products
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// featured block title
	wp.customize( 'wonkode_woo_featured_products_block_title', function( value ) {
		value.bind( function( to ) {
			$( '.featured-products-wrapper .block-title' ).text( to );
		} );
	} );
    // featured block text one
	wp.customize( 'wonkode_woo_featured_products_block_text_one', function( value ) {
		value.bind( function( to ) {
			$( '.featured-products-wrapper .block-text-one' ).text( to );
		} );
	} );

    // featured block text two
	wp.customize( 'wonkode_woo_featured_products_block_text_two', function( value ) {
		value.bind( function( to ) {
			$( '.featured-products-wrapper .block-text-two' ).text( to );
		} );
	} );

    // featured block link text
	wp.customize( 'wonkode_woo_featured_products_block_link_text', function( value ) {
		value.bind( function( to ) {
			$( '.featured-products-wrapper .block-link' ).text( to );
		} );
	} );

    // featured products button text
	wp.customize( 'wonkode_woo_featured_products_link_btn_text', function( value ) {
		value.bind( function( to ) {
			$( '.featured-products-wrapper .btn-featured-product' ).text( to );
		} );
	} );

} )( jQuery );