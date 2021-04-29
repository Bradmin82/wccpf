<?php
	function team_name_order_meta_handler( $item_id, $values, $cart_item_key ) {
// 		if(get_field('soccer_form')) {
// 		if($is_soccer === 'true') {	
		    if( WC()->session->__isset( $cart_item_key.'_team_name' ) ) {
		        wc_add_order_item_meta( $item_id, "Team Name", WC()->session->get( $cart_item_key.'_team_name') );
		    }
// 		} else { return true; }
	}

// add_action( 'woocommerce_add_order_item_meta', 'team_name_order_meta_handler', 1, 3 );