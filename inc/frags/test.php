<?php
	echo 'Hola mamacita';
	echo 'TEST Parent Cat $cat->term-id List<br /><pre>';
	print_r($secondary_cats);
	echo '</pre><br />';
	
	
	foreach ($secondary_cats as $scat) {	
		$scat_prod = wc_get_product($scat);
		// $scat_prod_title = $scat_prod->get_title();
/*
		$scat_prod = wc_get_product($scat);
		$scat_prod_title = $scat_prod->get_title();
		echo 'sup '.$scat_prod_title;	
*/
/*
		if(in_array($scat->term_id, $secondary_cats)) {
				echo '<h4 style="color:cornflowerblue;">SCat: ' . $cat->name . '</h4>';	
		}
*/
	}
	
	
	