<?php
/**
 * Update the order meta with field value
 */
 // below action added to root index.php or "ham.php"
//  add_action( 'woocommerce_checkout_update_order_meta', 'wccpf_checkout_field_update_order_meta' );

function wccpf_checkout_field_update_order_meta( $cart_item_key, $product_id = null, $quantity= null, $variation_id= null, $variation= null ) {
	global $product;	
	
/*
	// clear cart
	global $woocommerce;
	$woocommerce->cart->empty_cart();
*/
	
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	$slugs = wp_list_pluck( $terms, 'slug' ); 
	$parents = wp_list_pluck( $terms, 'parent' );
	$counts = wp_list_pluck( $terms, 'count' );
	$term_taxonomy_ids = wp_list_pluck( $terms, 'term_taxonomy_id' );
	$names = wp_list_pluck( $terms, 'name' );
	// print the names, for funzies
	//if ( current_user_can( 'manage_options' ) ) { print("<pre>".print_r($names, true)."</pre>");}

	
	// This will be the loop for all product pages to display the form assigned, if assigned
	include('wccpf-get-cats.php');
	// Use ^this frag instead of wp_list_pluck()ing above, replace necessary vars below carefully, and get the loop right with prod ids matching prod 
	$numOfSecondaryProdCats = count($secondary_cats);
	$numOfSecondaryProdCatsCount = 0;

	while($numOfSecondaryProdCatsCount < $numOfSecondaryProdCats) {
		$secondaryProdOptionName = 'ham_form_field_'.$numOfSecondaryProdCatsCount;
		//if(get_the_title($secondary_cats[$numOfSecondaryProdCatsCount]) != 'Soccer Banners') {
		if(current_user_can( 'manage_options' )) { 
			foreach($term_taxonomy_ids as $term_taxonomy_id) {
				if($term_taxonomy_id == $secondary_cats[$numOfSecondaryProdCatsCount] && get_option($secondaryProdOptionName) != null && get_option($secondaryProdOptionName) !== '') {
					$class_name = preg_replace('/ /i', '-', strtolower($secondary_cat_names[$numOfSecondaryProdCatsCount]));
					$matches = [];
					$url = get_option($secondaryProdOptionName);
 					$get_form_id = preg_match('/(\[*id=.)(\d+).*(.\])/', $url, $matches);
 					$cf7_form_id = $matches[2];
 					if($cf7_form_id != null && $cf7_form_id !== '') {
						$ContactForm = WPCF7_ContactForm::get_instance( $cf7_form_id );
						$form_fields = $ContactForm->scan_form_tags();
						$form_field_names = [];
						foreach($form_fields as $form_field) {
							array_push($form_field_names, $form_field['name']);							
						}
						$field_count = count($form_field_names);
						for($i = 0; $i < $field_count; $i++) {
							if($form_fields[$i]->type != 'submit' && $form_fields[$i]->type != null) {
								/*
								 * Do something with the wccpf form fields
								 */
								 if( isset( $_REQUEST[$form_fields[$i]->name] ) ) {
								    $underscore_name = str_replace('-', '_', $form_fields[$i]->name);
							    
								    if ( ! empty( $_POST[$underscore_name] ) ) {
								        update_post_meta( $order_id, $form_fields[$i]->name.' Field', sanitize_text_field( $_POST[$underscore_name] ) );
								    }
								 }
							    return true;
							}
						}
					} else {
						echo '<h4 class="'.$class_name.'-form-unavailable" style="color:#f00;">No HAM form [shortcode] added for this product cat.</h4>';
					}					
				}
			}
		}
		$numOfSecondaryProdCatsCount++;
	}
}
// below action NEEDS TO BE added to root index.php or "ham.php"
// action appended to wccpf-do.php
// add_action( 'woocommerce_checkout_update_order_meta', 'wccpf_checkout_field_update_order_meta', 52);

