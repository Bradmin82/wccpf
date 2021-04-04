<?php
/**
 * Update the cart checkout with wccpf form values
 */

function wccpf_render_meta_on_cart_item( $title = null, $cart_item = null, $cart_item_key = null ) {
    if( $cart_item_key && WC()->session->__isset( $cart_item_key.'_team_name' ) ) {
        echo $title. '<dl class="cart-only">
                 <dt class="">HAM Team Name: </dt>
                 <dd class=""><p>'. WC()->session->get( $cart_item_key.'_team_name') .'</p></dd>         
              </dl>';
    }
    if( $cart_item_key && WC()->session->__isset( $cart_item_key.'_colors' ) ) {
        echo $title. '<dl class="cart-only">
                 <dt class="">Team Colors: </dt>
                 <dd class=""><p>'. WC()->session->get( $cart_item_key.'_colors') .'</p></dd>         
              </dl>';
    } else {
        echo $title;
    }
}
 // below action NEEDS TO BE added to root index.php or "ham.php"
// 	add_filter( 'woocommerce_cart_item_name', 'wccpf_render_meta_on_cart_item', 1, 3 );