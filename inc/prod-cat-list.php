<?php

include('frags/wccpf-get-cats.php');
// echo '<h2>Parent ID: '. $cat->category_parent . '</h2>';
echo 'Parent Cat $cat->term-id List<br /><pre>';
print_r($secondary_cats);
echo '</pre><br />';
echo 'Secondary Cat Names, length: ' . count($secondary_cats);	
	
foreach ($all_categories as $cat) {		
	if(in_array($cat->term_id, $secondary_cats)) {
		// echo '<h4 style="color:cornflowerblue;">Cat: ' . $cat->name . '</h4>';	
	}
/*
	echo '<pre>';
	print_r($cat);
	print_r($parent_cats);
	echo '</pre>';
*/
	    
    $category_id = $cat->term_id;     

//     echo '<br /><h4><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></h4>';
    $sub_cats = get_categories( $args );
    if($sub_cats) {
        foreach($sub_cats as $sub_category) {
            // echo  '<pre>'.$sub_category->name.'</pre>';
/*
            echo  '<a href="'.$sub_category->slug.'">'.$sub_category->name.'</a>';
            // print_r($sub_category);
            echo $sub_category->term_id;
            echo $sub_category->slug;
            echo '<br/>';
*/
        }

    }
}     

?>