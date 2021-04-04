<?php
include('wccpf-get-cats.php');	
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
					echo do_shortcode(get_option($secondaryProdOptionName));
					echo '<br>'.$cf7_form_id;
					echo '</div>';
 					if($cf7_form_id != null && $cf7_form_id !== '') {
						$ContactForm = WPCF7_ContactForm::get_instance( $cf7_form_id );
						$form_fields = $ContactForm->scan_form_tags();
						$form_field_names = [];
						foreach($form_fields as $form_field) {
							array_push($form_field_names, $form_field['name']);
							//echo print_r($form_field);
							
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