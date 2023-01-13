<?php
/**
 * The searchform.php template.
 * 
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package WonKode
 * @since 1.0
 */
// $wonkode_unique_id_alt = esc_attr( uniqid( 'search-form' ) );
$wonkode_unique_id = wp_unique_id( 'search-form-' );
?>
<!-- 
<form role="search" aria-label="Search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="search" id="<?php echo esc_attr( $wonkode_unique_id ); ?>" class="form-control" placeholder="<?php _e( 'Search', 'wonkode' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="btn btn-secondary"><?php _e( 'Search', 'wonkode' ); ?></button>
    </div>
</form> -->

<form role="search" aria-label="Search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="floaticon-input">
        <input type="search" id="<?php echo esc_attr( $wonkode_unique_id ); ?>" class="form-control" placeholder="<?php _e( 'Search...', 'wonkode' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
        <button type="submit" class="floaticon-input-addon">
            <svg class="floaticon" width="24" height="24" aria-hidden="true" focusable="false"><use xlink:href="#search-icon" /></svg>
        </button>
    </div>
</form>
