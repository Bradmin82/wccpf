<?php
/**
 * Save the wccpf form field values
 */

function wccpf_save_fields( $cart_item_key, $product_id = null, $quantity= null, $variation_id= null, $variation= null ) {
    if( isset( $_REQUEST['team-name'] ) ) {
        WC()->session->set( $cart_item_key.'_team_name', $_REQUEST['team-name'] );
    }
    echo '<h6 style="color:hotpink;position:absolute;top:100px;"><pre>'.print_r($form_fields, $secondary_cat_names).'</pre>'.$secondary_cat_names[1].'hmm</h6>';
    foreach($form_fields as $form_field) {
		//array_push($form_field_names, $form_field['name']);
		echo '<h6 style="color:hotpink;">'.print_r($form_field).'</h6>';
		
	}
}
// below action NEEDS TO BE added to root index.php or "ham.php"
// add_action( 'woocommerce_add_to_cart', 'wccpf_save_fields', 1, 5 );

/*
include('inc/frags/wccpf-get-cats.php');
    $numOfFields = count($secondary_cats);
    $hamFieldCount = 0;
	while($hamFieldCount < $numOfFields) {	
		$hamFieldName = 'ham_form_field_'.$hamFieldCount;
		add_settings_field($hamFieldName, $hamFieldName.' <pre>'.$secondary_cat_names[$hamFieldCount].'</pre>[shortcode]:', "display_ham_fields", "wccpf-options", "fresh_meat_section", $hamFieldCount);
		register_setting("fresh_meat_section", $hamFieldName, $hamFieldCount);
		$hamFieldCount++;
	}
*/