<?php
/**
 * Save the wccpf form field values
 */

function wccpf_save_fields( $cart_item_key, $product_id = null, $quantity= null, $variation_id= null, $variation= null ) {
	global $product;	
	
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
	
	//wp_enqueue_script('wccpfadminscripts', 'http://www.shopblackline.com/wp-content/plugins/ham/wccpf.js', array( 'jquery' ) );
	
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
					echo '<h2>Woof Woof, Customize '.$secondary_cats[$numOfSecondaryProdCatsCount].'. your '.$names[0].'. '.$secondary_cat_names[$numOfSecondaryProdCatsCount].' '.$numOfSecondaryProdCatsCount.' here</h2>'; 
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
						for($i = 0; $i < count($form_field_names); $i++) {
							if($form_fields[$i]->type != 'submit') {
							echo '<h1 style="color:brown;">'.$form_fields[$i]->name.'</h1>';
							echo '<h4 style="color:brown;">'.$form_fields[$i]->type.'</h4>';
								$ham_field_value = $form_fields[$i]->name.'_field';
/*
								woocommerce_form_field( $ham_field_value, array(
							        'type'          => $form_fields[$i]->type,
							        'class'         => array('ham-field-class form-row-wide'),
							        'label'         => __($ham_field_value),
							        'placeholder'   => __(''),
							        ), 
							        $checkout->get_value( $ham_field_value )
							    );
*/
							}
						}
						 echo '<h6 style="color:hotpink;position:absolute;top:100px;"><pre>'.print_r($form_fields, $secondary_cat_names).'</pre>'.$secondary_cat_names[1].'</h6>';
						foreach($form_fields as $form_field) {
							//array_push($form_field_names, $form_field['name']);
							echo '<h6 style="color:hotpink;">'.print_r($form_field).'</h6>';
						
						}
/*
						foreach($form_field_names as $form_field_name) {
							echo '<h1 class="'.$class_name.'-form-field-name" style="color:#f00;">'.$form_field_name.'</h1>';
						}
*/
					} else {
						echo '<h4 class="'.$class_name.'-form-unavailable" style="color:#f00;">No HAM form [shortcode] added for this product cat.</h4>';
					}					
				}
			}
		}
		$numOfSecondaryProdCatsCount++;
	}

/*
	include('wccpf-get-cats.php');
    if( isset( $_REQUEST['team-name'] ) ) {
        WC()->session->set( $cart_item_key.'_team_name', $_REQUEST['team-name'] );
    }
    echo '<h6 style="color:hotpink;position:absolute;top:100px;"><pre>'.print_r($form_fields, $secondary_cat_names).'</pre>'.$secondary_cat_names[1].'</h6>';
    foreach($form_fields as $form_field) {
		//array_push($form_field_names, $form_field['name']);
		echo '<h6 style="color:hotpink;">'.print_r($form_field).'</h6>';
		
	}
*/
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