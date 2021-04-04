<?php
/**
 * Update the order meta with field value
 */
 // below action added to root index.php or "ham.php"
//  add_action( 'woocommerce_checkout_update_order_meta', 'wccpf_checkout_field_update_order_meta' );

function wccpf_checkout_field_update_order_meta() {
/*
	if ( ! empty( $_POST['league_field'] ) ) {
        update_post_meta( $order_id, 'League Field', sanitize_text_field( $_POST['league_field'] ) );
    }
*/
}