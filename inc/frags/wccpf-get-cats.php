<?php
  $taxonomy     = 'product_cat';
  $orderby      = 'id';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;
  
  $orderbyName      = 'name'; 
  
$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty
);
// replicate $all_categories w/ different 'ordderby'
$all_categories = get_categories( $args );


// print_r($all_categories);
$all_categories_keyed  = [];
$parent_cats = [];
$secondary_cats = [];
$all_categories_keyed_count = 0;
foreach ($all_categories as $cat) {
    // print_r($cat);   
    // $all_categories_keyed[$all_categories_keyed_count] = "35";
    $parent_cat_checker = $cat->category_parent; 
    if($parent_cat_checker == 0) {
	    array_push($parent_cats, $cat->term_id);
	}
	$all_categories_keyed_count++;
}
foreach ($all_categories as $cat) {
	if(in_array($cat->category_parent, $parent_cats)) {
		// echo '<h1>Eureka!<br />' . $cat->name . '</h1>';
		array_push($secondary_cats, $cat->term_id);
	}
}
$secondary_cat_names = [];
foreach ($all_categories as $cat) {		
	if(in_array($cat->term_id, $secondary_cats)) {
		array_push($secondary_cat_names, $cat->name);
	}
}