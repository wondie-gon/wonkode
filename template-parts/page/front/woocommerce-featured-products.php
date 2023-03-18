<?php
/**
 * Frontpage woocommerce products template. 
 * Install WooCommerce to display featured products 
 * on frontpage using this template file.
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// woocommerce customize
$wonkode_woo_block_title = get_theme_mod( 'wonkode_woo_featured_products_block_title', WK_DEFAULTS['_woo_featured_products_block_title'] );
$wonkode_woo_block_text_one = get_theme_mod( 'wonkode_woo_featured_products_block_text_one', WK_DEFAULTS['_woo_featured_products_block_text_one'] );
$wonkode_woo_block_text_two = get_theme_mod( 'wonkode_woo_featured_products_block_text_two', WK_DEFAULTS['_woo_featured_products_block_text_two'] );
$wonkode_woo_block_link = get_theme_mod( 'wonkode_woo_featured_products_block_link', WK_DEFAULTS['_woo_featured_products_block_link'] );
$wonkode_woo_block_link_text = get_theme_mod( 'wonkode_woo_featured_products_block_link_text', WK_DEFAULTS['_woo_featured_products_block_link_text'] );
$wonkode_woo_featured_prod_btn_text = get_theme_mod( 'wonkode_woo_featured_products_link_btn_text', WK_DEFAULTS['_woo_featured_products_link_btn_text'] );

// open featured products section wrapper
WonKode_Site_Content_Area::open_section_inner_container( 'featured-products-wrapper' );
    // row
    WonKode_Site_Content_Area::open_content_wrapper_row( 'row-cols-1 row-cols-md-3 align-items-stretch g-4' );
?>
        <div class="col intro-block">
            <div class="h-100">
                <h1 class="block-title wow slideInUp" data-wow-delay="0.3s"><?php echo sprintf( esc_html__( '%s', 'wonkode' ), $wonkode_woo_block_title ); ?></h1>
                <p class="block-text-one wow slideInUp" data-wow-delay="0.4s"><?php echo sprintf( esc_html__( '%s', 'wonkode' ), $wonkode_woo_block_text_one ); ?></p>
                <p class="block-text-two wow slideInUp" data-wow-delay="0.4s"><?php echo sprintf( esc_html__( '%s', 'wonkode' ), $wonkode_woo_block_text_two ); ?></p>
                <a href="<?php echo esc_url( $wonkode_woo_block_link ); ?>" class="btn block-link animated slideInUp"><?php echo sprintf( esc_html__( '%s', 'wonkode' ), $wonkode_woo_block_link_text ); ?><i class="fa fa-shopping-basket ms-2"></i></a>
            </div>
        </div>
    <?php
        $prod_args = array( 
            'post_type'         => 'product', 
            'posts_per_page'    => 2, 
            'orderedby'         => 'date', 
            'tax_query'         => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ),
            )
        );
        // init product query
        $wonkode_prod_loop = new WP_Query( $prod_args );

        while ( $wonkode_prod_loop->have_posts() ) {
            $wonkode_prod_loop->the_post();
            global $product;
            $prod_img_url = wp_get_attachment_url( get_post_thumbnail_id( $wonkode_prod_loop->post->ID ) );
            ?>
            <div class="col product-block wow slideInRight" data-wow-delay="0.5s">
                <div class="card card-cover h-100" style="background-image: url('<?php echo esc_url( $prod_img_url ); ?>');">
                    <div class="d-flex flex-column h-100 p-3">
                        <ul class="d-flex list-unstyled mt-auto justify-content-between">
                            <li class="d-flex flex-column">
                                <span class="product-name"><?php the_title(); ?></span>
                                <span class="product-price">&dollar;<?php echo $product->get_price(); ?></span>
                            </li>
                            <li class="d-flex">
                                <a href="<?php echo esc_url( get_permalink( $wonkode_prod_loop->post->ID ) ); ?>" class="btn btn-featured-product"><?php echo sprintf( esc_html__( '%s', 'wonkode' ), $wonkode_woo_featured_prod_btn_text ); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    // close row
    WonKode_Site_Content_Area::close_content_wrapper_row();
// closing featured products section wrapper
WonKode_Site_Content_Area::close_section_inner_container();