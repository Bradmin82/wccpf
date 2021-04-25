<?php
function wccpf_product_loop($incoming_product_action) {
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
/*
	$form_1 = get_option('wccpf_form_field_1');
	$form_2 = get_option('wccpf_form_field_2');
*/
	
	// This will be the loop for all product pages to display the form assigned, if assigned
	include('wccpf-get-cats.php');
	// Use ^this frag instead of wp_list_pluck()ing above, replace necessary vars below carefully, and get the loop right with prod ids matching prod 
	$numOfSecondaryProdCats = count($secondary_cats);
	$numOfSecondaryProdCatsCount = 0;
	while($numOfSecondaryProdCatsCount < $numOfSecondaryProdCats) {
		$secondaryProdOptionName = 'ham_form_field_'.$numOfSecondaryProdCatsCount;
		//if(get_the_title($secondary_cats[$numOfSecondaryProdCatsCount]) != 'Soccer Banners') {
		if(current_user_can( 'manage_options' )) { 
			//echo '<h6 style="color:brown;">'.get_option($secondaryProdOptionName).', $term_taxonomy_ids: '.count($term_taxonomy_ids).'</h6>';
			foreach($term_taxonomy_ids as $term_taxonomy_id) {
				//echo '<h1 style="color:brown;">Hey now'.$term_taxonomy_id.', $term_taxonomy_ids: '.count($term_taxonomy_ids).'</h1>';
				if($term_taxonomy_id == $secondary_cats[$numOfSecondaryProdCatsCount] && get_option($secondaryProdOptionName) != null && get_option($secondaryProdOptionName) !== '') {
				$class_name = preg_replace('/ /i', '-', strtolower($secondary_cat_names[$numOfSecondaryProdCatsCount]));
				$matches = [];
				$url = get_option($secondaryProdOptionName);
					$get_form_id = preg_match('/(\[*id=.)(\d+).*(.\])/', $url, $matches);
					$cf7_form_id = $matches[2];
					echo '<h1 style="color:brown;">Hey now'.get_option($secondaryProdOptionName).'</h1>';

 					if($cf7_form_id != null && $cf7_form_id !== '') {
						$ContactForm = WPCF7_ContactForm::get_instance( $cf7_form_id );
						$form_fields = $ContactForm->scan_form_tags();
						$form_field_names = [];
						foreach($form_fields as $form_field) {
							array_push($form_field_names, $form_field['name']);
							//echo print_r($form_field);
							
						}
						$wccpf_field_values = [];
						for($i = 0; $i < count($form_field_names); $i++) {
							if($form_fields[$i]->type != 'submit') {
								echo '<h1 style="color:brown;">'.$form_fields[$i]->name.'</h1>';
								echo '<h4 style="color:brown;">'.$form_fields[$i]->type.'</h4>';
								$wccpf_field_values[$i] = $form_fields[$i]->name.'_field';
							}
						}
						if($incoming_product_action != null) {
							echo $incoming_product_action;
						}
						
					}
				}
			}
		}
	}
	return;
}
// wccpf_product_loop();