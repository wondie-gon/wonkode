/**
 * File customize-preview.js.
 *
 * Customize preview for asynchronous live preview of theme customization.
 *
 */

( function( $ ) {

    /**
     * ----------------------------------------------------------
     * Customize preview for general site features and templates
     * ----------------------------------------------------------
     */
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
    /**
     * --------------------------------------------------------
     * Customize preview for frontpage templates customization
     * --------------------------------------------------------
     */
    // _front_selected_posts_section_title
    wp.customize( 'wonkode_front_selected_posts_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.selected-posts-wrapper .page-section-title' ).text( to );
        } );
    } );

    // _front_selected_posts_cols_sm
    wp.customize( 'wonkode_front_selected_posts_cols_sm', function( value ) {
        value.bind( function( to ) {
            // var row_class_sm = "row-cols-sm-" + to;
            $( '.selected-posts-wrapper .row' ).toggleClass( 'row-cols-sm-' + to );
        } );
    } );
    // _front_selected_posts_cols_md
    wp.customize( 'wonkode_front_selected_posts_cols_md', function( value ) {
        value.bind( function( to ) {
            $( '.selected-posts-wrapper .row' ).toggleClass( 'row-cols-md-' + to );
        } );
    } );
    // _front_selected_posts_cols_lg
    wp.customize( 'wonkode_front_selected_posts_cols_lg', function( value ) {
        value.bind( function( to ) {
            $( '.selected-posts-wrapper .row' ).toggleClass( 'row-cols-lg-' + to );
        } );
    } );


    // _front_selected_posts_section_bg_color
    wp.customize( 'wonkode_front_selected_posts_section_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.selected-posts-wrapper' ).css( 'background-color', to );
        } );
    } );
    // _front_selected_posts_section_title_color
    wp.customize( 'wonkode_front_selected_posts_section_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.selected-posts-wrapper .page-section-title' ).css( 'color', to );
        } );
    } );
    /**
     * --------------------------------------------------
     * Customize preview for woocommerce 
     * featured products
     * --------------------------------------------------
     */
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

} ) ( jQuery );