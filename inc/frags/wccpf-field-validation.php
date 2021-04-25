<?php
/**
 * Validate the wccpf form fields
 */

function wccpf_field_validation( $cart_item_key, $product_id = null, $quantity= null, $variation_id= null, $variation= null ) {
	global $product;	
	
/*
	// clear cart
	global $woocommerce;
	$woocommerce->cart->empty_cart();
*/

/*
// wordpress.stackexchange.com/questions/55813/the-hook-for-the-ajax-add-to-cart-button
global $post; // Assuming it's already set up
$_product = &new woocommerce_product( $post->ID );
woocommerce_template_loop_add_to_cart( $post, $_product );
*/
// That means the AJAX hooks aren't being added. add_action('wp_ajax_woocommerce_add_to_cart', 'woocommerce_ajax_add_to_cart'); and add_action('wp_ajax_nopriv_woocommerce_add_to_cart', 'woocommerce_ajax_add_to_cart');
	
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
							    if( empty( $_REQUEST[$form_fields[$i]->name] ) ) {
							        wc_add_notice( __( 'Please fill all form fields', 'woocommerce' ), 'error' );
							        return false;
							    }
							    
/*
							    public function validate( $field_label, $value ) {
									$field_to_compare_value = sanitize_text_field( $_POST[ $this->field_to_compare ] );
									$valid = $field_to_compare_value === $value;
									if ( ! $valid ) {
										wc_add_notice( sprintf( __( 'Invalid %1$s value.', 'wpdesk' ), '<strong>' . $field_label . '</strong>' ), 'error' );
									}
								}
								// investigate these wc methods:
								// woocommerce_checkout_process
								// woocommerce_checkout_order_processed
*/
							}
						}
						return true;
					} else {
						return true;
					}					
				}
			}
		}
		$numOfSecondaryProdCatsCount++;
	}
}
// below action NEEDS TO BE added to root index.php or "ham.php"
// action appended to wccpf-do.php
// add_action( 'woocommerce_add_to_cart_validation', 'wccpf_field_validation', 10, 5 );
		