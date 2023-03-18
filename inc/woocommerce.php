<?php
/**
 * Add WooCommerce support to theme
 * 
 * @since 1.0
 * 
 * For more:
 * @see https://woocommerce.com/document/woocommerce-theme-developer-handbook/
 * 
 * @package WonKode
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Defines function of theme support for woocommerce.
 */
if ( ! function_exists( 'wonkode_add_woocommerce_support' ) ) {
    /**
     * Adds theme support for woocommerce.
     * 
     * @since 1.0
     * @return void
     */
    function wonkode_add_woocommerce_support() {
        add_theme_support( 'woocommerce', array(
            'thumbnail_image_width' => 300,
            'single_image_width'    => 600,
    
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 3,
                'min_columns'     => 1,
                'max_columns'     => 4,
            ),
        ) );
    }
}

/**
 * Defines function of theme support for 
 * woocommerce product gallery features.
 */
if ( ! function_exists( 'wonkode_add_woocommerce_product_gallery_features' ) ) {
    /**
     * Adds theme support for woocommerce 
     * product gallery features.
     * 
     * @since 1.0
     * @return void
     */
    function wonkode_add_woocommerce_product_gallery_features() {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}

/**
 * Defines function to add custom classes to 
 * woocommerce page 'body' tag.
 */
if ( ! function_exists( 'wonkode_woocommerce_body_class' ) ) {
	/**
	 * Filter function that adds class to 
	 * woocommerce page body tag.
	 * 
	 * @since 1.0
	 * @param array $classes	Array of woocommerce body classes
	 * @return array 			Array of classes including the added ones.
	 */
	function wonkode_woocommerce_body_class( $classes ) {
		if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() ) {
			$classes[] = WK_TXTDOM . '-woocommerce';
		} else {
			if ( is_cart() ) {
				$classes[] = WK_TXTDOM . '-woocommerce-cart';
			} elseif ( is_checkout() ) {
				$classes[] = WK_TXTDOM . '-woocommerce-checkout';
			}
		}
		return $classes;
	}
}

/**
 * Defines function to enqueue custom styles 
 * for woocommerce different pages.
 */
if ( ! function_exists( 'wonkode_enqueue_woocommerce_custom_styles' ) ) {
	/**
	 * Callback function to enqueue custom styles 
	 * for woocommerce pages.
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_enqueue_woocommerce_custom_styles() {
		// get version
		$ver = wonkode_is_on_localhost() ? time() : wp_get_theme()->get( 'Version' );

		// register woocommerce custom styles
		wp_register_style( 'wonkode-woo-custom', WK_ASSETS_URL . '/css/woo-custom.css', array( 'woocommerce-general', 'wonkode-bootstrap', 'wonkode-customstyles' ), $ver, 'all' );

		// register style for product, product tag and category pages
		wp_register_style( 'wonkode-woo-product', WK_ASSETS_URL . '/css/woo-product.css', array( 'wonkode-woo-custom' ), $ver, 'all' );

		// register style for cart and checkout pages
		wp_register_style( 'wonkode-woo-cart-checkout', WK_ASSETS_URL . '/css/woo-cart-checkout.css', array( 'wonkode-woo-custom' ), $ver, 'all' );

		if ( is_woocommerce() ) {
			wp_enqueue_style( 'wonkode-woo-custom' );
		} 

		// enqueue on product, product tag and category pages
		if ( is_product() || is_product_tag() || is_product_category() ) {
			wp_enqueue_style( 'wonkode-woo-product' );
		} 

		// enqueue on cart and checkout pages
		if ( is_cart() || is_checkout() ) {
			wp_enqueue_style( 'wonkode-woo-cart-checkout' );
		}
	}
}

/**
 * Defines function to modify woocommerce before main content
 */
if ( ! function_exists( 'wonkode_woocommerce_before_main_content' ) ) {
	/**
	 * Callback function to hook to 
	 * woocommerce before main content
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_woocommerce_before_main_content() {
		// open woocommerce content wrapper outer container
		WonKode_Site_Content_Area::open_section_outer_container( 'bg-pure-white' );
		// open woocommerce content wrapper inner container
		// WonKode_Site_Content_Area::open_section_inner_container();
	}
}

/**
 * Defines function to modify woocommerce after main content
 */
if ( ! function_exists( 'wonkode_woocommerce_after_main_content' ) ) {
	/**
	 * Callback function to hook to 
	 * woocommerce after main content
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_woocommerce_after_main_content() {
		// closing woocommerce content wrapper inner container
		// WonKode_Site_Content_Area::close_section_inner_container();
		// closing woocommerce content wrapper outer container
		WonKode_Site_Content_Area::close_section_outer_container();
	}
}

/**
 * Defines callback function to filter 
 * the WooCommerce Breadcrumb.
 */
if ( ! function_exists( 'wonkode_woocommerce_modify_breadcrumb_defaults' ) ) {
	/**
	 * Filters the WooCommerce Breadcrumb.
	 * 
	 * @since 1.0
	 * @param array $defaults 	Default arguments for WooCommerce Breadcrumb.
	 * @return array			Parsed array of arguments.
	 */
	function wonkode_woocommerce_modify_breadcrumb_defaults( $defaults ) {
		$defaults = array(
			'delimiter'   => '&nbsp;&gt;&nbsp;',
			'wrap_before' => '<div class="row woocommerce-breadcrumb-row"><div class="col my-2"><nav aria-label="breadcrumb" class="woocommerce-breadcrumb"><ol class="breadcrumb">',
			'wrap_after'  => '</ol></nav></div></div>',
			'before'      => '<li class="breadcrumb-item">',
			'after'       => '</li>',
			'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
		);
		return $defaults;
	}
}


if ( ! function_exists( 'wonkode_wc_form_field_args' ) ) {
	/**
	 * Filter hook function monkey patching form classes
	 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
	 *
	 * @param string $args Form attributes.
	 * @param string $key Not in use.
	 * @param null   $value Not in use.
	 *
	 * @return mixed
	 */
	function wonkode_wc_form_field_args( $args, $key, $value = null ) {
		// Start field type switch case.
		switch ( $args['type'] ) {
			// Targets all select input type elements, except the country and state select input types.
			case 'select':
				/*
				 * Add a class to the field's html element wrapper - woocommerce
				 * input types (fields) are often wrapped within a <p></p> tag.
				 */
				$args['class'][] = 'form-group mb-3';
				// Add a class to the form input itself.
				$args['input_class'][] = 'form-control';
				// Add custom data attributes to the form input itself.
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;

			/*
			 * By default WooCommerce will populate a select with the country names - $args
			 * defined for this specific input type targets only the country select element.
			 */
			case 'country':
				$args['class'][] = 'form-group mb-3 single-country';
				break;

			/*
			 * By default WooCommerce will populate a select with state names - $args defined
			 * for this specific input type targets only the country select element.
			 */
			case 'state':
				$args['class'][]           = 'form-group mb-3';
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			case 'textarea':
				$args['input_class'][] = 'form-control';
				break;
			case 'checkbox':
					$args['class'][] = 'form-group mb-3';
					// Wrap the label in <span> tag.
					$args['label'] = isset( $args['label'] ) ? '<span class="custom-control-label">' . $args['label'] . '<span>' : '';
					// Add a class to the form input's <label> tag.
					$args['label_class'][] = 'custom-control custom-checkbox';
					$args['input_class'][] = 'custom-control-input';
				break;
			case 'radio':
				$args['label_class'][] = 'custom-control custom-radio';
				$args['input_class'][] = 'custom-control-input';
				break;
			default:
				$args['class'][]       = 'form-group mb-3';
				$args['input_class'][] = 'form-control';
				break;
		} // End of switch ( $args ).
		return $args;
	}
}

if ( ! is_admin() && ! function_exists( 'wc_review_ratings_enabled' ) ) {
	/**
	 * Check if reviews are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_reviews_enabled() {
		return 'yes' === get_option( 'woocommerce_enable_reviews' );
	}

	/**
	 * Check if reviews ratings are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_review_ratings_enabled() {
		return wc_reviews_enabled() && 'yes' === get_option( 'woocommerce_enable_review_rating' );
	}
}

/**
 * Defines function that adds Bootstrap classes 
 * to woocommerce quantity input field.
 */
if ( ! function_exists( 'wonkode_wc_quantity_input_classes' ) ) {
	/**
	 * Add Bootstrap class to woocommerce 
     * quantity input field.
	 *
	 * @param array $classes Array of quantity input classes.
	 * @return array
	 */
	function wonkode_wc_quantity_input_classes( $classes ) {
		$classes[] = 'form-control';
		return $classes;
	}
}

/**
 * Defines funtion callback for single product image gallery 
 * classes
 */
if ( ! function_exists( 'wonkode_woocommerce_single_product_image_gallery_classes' ) ) {
	/**
	 * Filter callback for single product image gallery wrapper 
	 * class. 
	 * 
	 * @since 1.0
	 * @param array $wrapper_classes 	Array of the gallery image wrapper 
	 * 									classes from woocommerce.
	 * @return array Merged/modified array of classes.
	 */
	function wonkode_woocommerce_single_product_image_gallery_classes( $wrapper_classes ) {
		$wrapper_classes = wp_parse_args( $wrapper_classes, array( 'col-12', 'col-sm-6' ) );
		return $wrapper_classes;
	}
}

/**
 * Defines funtion callback for single product reviews form
 * arguments. 
 */
if ( ! function_exists( 'wonkode_woocommerce_product_review_form_args' ) ) {
	/**
	 * Filter callback for single product reviews form
	 * arguments. 
	 * 
	 * @since 1.0
	 * @param array $comment_form 	Arguments of product review form. 
	 * @return array Modified form arguments for product reviews.
	 */
	function wonkode_woocommerce_product_review_form_args( $comment_form ) {
		$commenter    = wp_get_current_commenter();
		$comment_form = array(
			/* translators: %s is product title */
			'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
			/* translators: %s is product title */
			'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
			'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
			'title_reply_after'   => '</span>',
			'comment_notes_after' => '',
			'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
			'logged_in_as'        => '',
			'comment_field'       => '',
		);

		$name_email_required = (bool) get_option( 'require_name_email', 1 );
		$fields              = array(
			'author' => array(
				'label'    => __( 'Name', 'woocommerce' ),
				'type'     => 'text',
				'value'    => $commenter['comment_author'],
				'required' => $name_email_required,
			),
			'email'  => array(
				'label'    => __( 'Email', 'woocommerce' ),
				'type'     => 'email',
				'value'    => $commenter['comment_author_email'],
				'required' => $name_email_required,
			),
		);

		$comment_form['fields'] = array();

		foreach ( $fields as $key => $field ) {
			$field_html  = '<div class="comment-form-' . esc_attr( $key ) . ' form-floating mb-3">';
			$field_html .= '<input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" class="form-control" ' . ( $field['required'] ? 'required' : '' ) . ' />';
			$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

			if ( $field['required'] ) {
				$field_html .= '&nbsp;<span class="required">*</span>';
			}

			$field_html .= '</label></div>';

			$comment_form['fields'][ $key ] = $field_html;
		}

		$account_page_url = wc_get_page_permalink( 'myaccount' );
		if ( $account_page_url ) {
			/* translators: %s opening and closing link tags respectively */
			$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
		}

		if ( wc_review_ratings_enabled() ) {
			$comment_form['comment_field'] = '<div class="comment-form-rating mb-3"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
				<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
				<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
				<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
				<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
				<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
				<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
			</select></div>';
		}

		$comment_form['comment_field'] .= '<div class="comment-form-comment form-floating mb-3">';

		$comment_form['comment_field'] .= '<textarea id="comment" name="comment" class="form-control" cols="45" rows="8" required></textarea>';
		$comment_form['comment_field'] .= '<label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label>';
		$comment_form['comment_field'] .= '</div>';

		$comment_form['class_submit'] = 'btn btn-submit-review';
		$comment_form['label_submit'] = __( 'Post Review', 'woocommerce' );

		return $comment_form;
	}
}