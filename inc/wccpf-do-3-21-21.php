<?php
function action_get_those_prod_cats() {
	global $product;
	// global $hamFieldCount;
	// not passing $hamFieldCount properly
	// echo '<h1>hamfc '.$hamFieldCount.'</h1>';
	
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
	$form_1 = get_option('wccpf_form_field_1');
	$form_2 = get_option('wccpf_form_field_2');
	$form_3 = get_option('wccpf_form_field_3');
	$form_4 = get_option('wccpf_form_field_4');
	$form_5 = get_option('wccpf_form_field_5');	
	$form_6 = get_option('wccpf_form_field_6');
	
	wp_enqueue_script('wccpfadminscripts', 'http://www.shopblackline.com/wp-content/plugins/ham/wccpf.js', array( 'jquery' ) );
	
	// This will be the loop for all product pages to display the form assigned, if assigned
	include('frags/wccpf-get-cats.php');
	// Use ^this frag instead of wp_list_pluck()ing above, replace necessary vars below carefully, and get the loop right with prod ids matching prod 
	$numOfSecondaryProdCats = count($secondary_cats);
	$numOfSecondaryProdCatsCount = 0;
/*
	while($numOfSecondaryProdCatsCount < $numOfSecondaryProdCats) {
		$secondaryProdOptionName = 'ham_form_field_'.$numOfSecondaryProdCatsCount;
		//if(get_the_title($secondary_cats[$numOfSecondaryProdCatsCount]) != 'Soccer Banners') {
			//if($term_taxonomy_ids[$numOfSecondaryProdCatsCount] == $secondary_cats[$numOfSecondaryProdCatsCount]) {
				if(current_user_can( 'manage_options' )) { 
					foreach($term_taxonomy_ids as $term_taxonomy_id) {
						if($term_taxonomy_id == $secondary_cats[$numOfSecondaryProdCatsCount] && get_option($secondaryProdOptionName) != null && get_option($secondaryProdOptionName) !== '') {
							echo '<h2>Customize '.$secondary_cats[$numOfSecondaryProdCatsCount].'. your '.$names[0].'. '.$secondary_cat_names[$numOfSecondaryProdCatsCount].' '.$numOfSecondaryProdCatsCount.' here</h2>'; 
							echo '<div class="wccpf ham '.$class_name.'">';
							echo get_option($secondaryProdOptionName);
							echo '</div>';
						}
					}
				}
			//}
		//}
		$numOfSecondaryProdCatsCount++;
	}
*/
while($numOfSecondaryProdCatsCount < $numOfSecondaryProdCats) {
		$secondaryProdOptionName = 'ham_form_field_'.$numOfSecondaryProdCatsCount;
		//if(get_the_title($secondary_cats[$numOfSecondaryProdCatsCount]) != 'Soccer Banners') {
		if(current_user_can( 'manage_options' )) { 
			foreach($term_taxonomy_ids as $term_taxonomy_id) {
				if($term_taxonomy_id == $secondary_cats[$numOfSecondaryProdCatsCount] && get_option($secondaryProdOptionName) != null && get_option($secondaryProdOptionName) !== '') {
					$class_name = preg_replace('/ /i', '-', strtolower($secondary_cat_names[$numOfSecondaryProdCatsCount]));
					echo '<h2>Customize '.$secondary_cats[$numOfSecondaryProdCatsCount].'. your '.$names[0].'. '.$secondary_cat_names[$numOfSecondaryProdCatsCount].' '.$numOfSecondaryProdCatsCount.' here</h2>'; 
					$matches = [];
					$url = get_option($secondaryProdOptionName);
 					$get_form_id = preg_match('/(\[*id=.)(\d+).*(.\])/', $url, $matches);
 					$cf7_form_id = $matches[2];
 					echo '<div class="wccpf ham '.$class_name.'">';
					echo get_option($secondaryProdOptionName);
					echo '<br>'.$cf7_form_id;
					echo '</div>';
 					if($cf7_form_id != null && $cf7_form_id !== '') {
						$ContactForm = WPCF7_ContactForm::get_instance( $cf7_form_id );
						$form_fields = $ContactForm->scan_form_tags();
						$form_field_names = [];
						foreach($form_fields as $form_field) {
							array_push($form_field_names, $form_field['name']);
							echo print_r($form_field);
							
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
						foreach($form_field_names as $form_field_name) {
							echo '<h1 class="'.$class_name.'-form-field-name" style="color:#f00;">'.$form_field_name.'</h1>';
						}
					} else {
						echo '<h4 class="'.$class_name.'-form-unavailable" style="color:#f00;">No HAM form [shortcode] added for this product cat.</h4>';
					}					
				}
			}
		}
		$numOfSecondaryProdCatsCount++;
	}
/*
			$form_ID     = 1538; # change the 1538 to your CF7 form ID
			$ContactForm = WPCF7_ContactForm::get_instance( $form_ID );
			$form_fields = $ContactForm->scan_form_tags();
			var_dump( $form_fields );


			woocommerce_form_field( 'team_name_field', array(
	        'type'          => 'text',
	        'class'         => array('team-name-field-class form-row-wide'),
	        'label'         => __('Team Name'),
	        'placeholder'   => __(''),
	        ), $checkout->get_value( 'team_name_field' ));
*/


	$numOfHamForms = count($secondary_cats);
	$hamFormCount = 0;
	while($hamFormCount < $numOfHamForms && current_user_can( 'manage_options' )) {	
		$hamFormName = 'ham_form_field_'.$hamFormCount;
		//echo esc_attr(get_option($hamFormName));
		//$sc_key = array_search('green', $array);
		// $scn = $secondary_cats[$hamFormCount]->name;
		if(get_option($hamFormName) !== null && get_option($hamFormName) !== '') {
			// echo '<pre>'.esc_attr(get_option($hamFormName)).'</pre>';
		}
		$hamFormCount++;
	}
	$cat_name_num = 0;
	// NOTE: THIS LOOP ONLY GOES THRU CATEGORY NAMES FOR ONE PRODUCTW!!!!!!!!!!!!
	foreach($names as $name) { 
		// Cat name string, replace spaces with dashes and uppercase with lowercase.
		$class_name = preg_replace('/ /i', '-', strtolower($name));
		if ( current_user_can( 'manage_options' ) ) {
			if($name == 'Birthday Invitations') { 
				// Below prints on prod page the prod cat name :)
				echo '<h2 style="color:chartreuse;">'.$name.' </h2>';
				echo '<div class="wccpf ham '.$class_name.'">';
				// Below prints on prod page the shortcode for a contact 7 form :)
				echo do_shortcode($form_2);	
				echo '</div>';
			}
			if($name == 'Baby Shower Invitations') { 
				echo '<h2 style="color:cornflowerblue;">Customize your '.$name.' here</h2>'; 
				echo '<div class="wccpf ham '.$class_name.'">';
				echo do_shortcode($form_1);
				//echo '<pre>' . esc_attr(dump_form_fields('2460')) . '</pre>';
				//below is broken
				//foreach($terms as $term) {echo '<pre>' . $term . '</pre>';}
				echo '</div>';
				
				
/*
				function add_fake_error($posted) {
				    if ($_POST['confirm-order-flag'] == "1") {
				        wc_add_notice( __( "custom_notice", 'fake_error' ), 'error');
				    } 
				}
				add_action('woocommerce_after_checkout_validation', 'add_fake_error');
*/
				
			}
			if($name == 'Baseball Banners') { 
				echo '<h2>Customize your '.$name.' here</h2>'; 
				echo get_option('ham_form_field_'.$cat_name_num);
				echo '<div class="wccpf ham '.$class_name.'">';
				echo do_shortcode($form_3);
				echo '</div>';
			}
			if($name == 'Soccer Banners') { 
				echo '<h2 style="color:hotpink;">Customize your '.$name.' here</h2>'; 
// 				echo ' '.$secondary_cat_names[$cat_name_num].' uggh';
				echo '<div class="wccpf ham '.$class_name.'">';
				echo do_shortcode($form_4);
				echo '</div>';
			}
			// Test a loop here, get_option('ham_form_field_'.$hamFieldCount)
// 			if(get_option('ham_form_field_'.$cat_name_num).length() > 0) {
			if($name == $secondary_cat_names[$cat_name_num] || $name == 'Soccer Banners') { 
				$fieldName = 'ham_form_field_'.$cat_name_num;
				echo '<h2>G\'dam, cat#'.$cat_name_num.' Customize your '.$name.' here</h2>'; 
				echo '<div class="wccpf ham '.$class_name.'">';
				echo get_option($fieldName);
				echo ' '.$secondary_cat_names[$cat_name_num].'</div>';
			}
		}
		if($name == 'Baseball Home Plate Pennants') { 
			echo '<h2>Customize your '.$name.' here</h2>'; 
			echo '<div class="wccpf ham '.$class_name.'">';
			echo do_shortcode($form_5);
			echo '</div>';
		}
		if($name == 'Softball Home Plate Pennants') { 
			echo '<h2>Customize your '.$name.' here</h2>'; 
			echo '<div class="wccpf ham '.$class_name.'">';
			echo do_shortcode($form_6);
			echo '</div>';
		}
		$cat_name_num++;
	}
}
//add_action('woocommerce_single_variation', 'action_get_those_prod_cats');
//add_action( 'woocommerce_before_add_to_cart_button', [ 'WooCommerce_Custom_Product_Forms', 'action_get_those_prod_cats' ], 49 );
/*
function dump_form_fields($x) {
	$form_ID     = $x;
	$ContactForm = WPCF7_ContactForm::get_instance( $form_ID );
	$form_fields = $ContactForm->scan_form_tags();
	var_dump( $form_fields );
}
*/

/**
 * Update the order meta with field value
 */
 include('frags/wccpf-checkout-update-order-meta.php');
 