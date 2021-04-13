<?php
/**
 * Display field value on the order edit page
 */

function wccpf_checkout_field_display_admin_order_meta($order){
	if(current_user_can( 'manage_options' )) {
/*
		echo '<div style="max-width:800px;white-space:prewrap;"><h5>This is price from cart_item[line_total] <pre>$'.$cart_item[line_total].'</pre></h5>';
		echo '<h5>Name: <pre>'.$cart_item[data]->name.'</pre></h5>';
		echo '<h5>Special key: <pre>'.$cart_item[key].'</pre></h5>';
		echo '<h5>Data: <pre>'.$cart_item[data].'</pre></h5></div>';
*/

		if( $cart_item_key && WC()->session->__isset($cart_item_key.'_callback_field_names') ) {
			$field_names = WC()->session->get( $cart_item_key.'_callback_field_names' );
			$field_names_count = count($field_names);
			if($field_names_count != null) {
				// echo '<h1>There are '.$field_names_count.' fields in this cats prod form</h1>';
				for($i = 0; $i <= $field_names_count; $i++) {
					$underscore_name = str_replace('-', '_', $field_names[$i]);
					$get_wccpf_field_value_handle = $cart_item_key.'_'.$underscore_name;
					if(WC()->session->__isset( $get_wccpf_field_value_handle )) {
						//if(WC()->session->get( $get_wccpf_field_value_handle) !== '') {
				        	echo '<dl class="ham checkout">
			                	<dt class="">HAM-'.$field_names[$i].': </dt>
								<dd class=""><p>'. WC()->session->get( $get_wccpf_field_value_handle) .'</p></dd>
								</dl>';
				    	//}
				    	echo '<p><strong>HAM '.__($field_names[$i]).':</strong> ' . get_post_meta( $order->id, $field_names[$i], true ) . '</p>';
				    }
			    }	
			}
		}
	}
}

// below action NEEDS TO BE added to root index.php or "ham.php"
// add_action( 'woocommerce_admin_order_data_after_billing_address', 'wccpf_checkout_field_display_admin_order_meta', 10, 1 );