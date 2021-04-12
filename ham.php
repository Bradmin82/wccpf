<?php
/**
 * @package Ham
 * @version 1.0
 */
/*
Plugin Name: Ham
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation!
Author: Mr. Brad
Version: 1.0
Author URI: https://bradweldy.com/wccpf/
*/

/*WordPress Menus API.*/
function add_new_menu_items()
{
    //add a new menu item. This is a top level menu item i.e., this menu item can have sub menus
    $pluginOptionsPage = 'wccpf_options_page';
    $icon              = 'dashicons-palmtree';
	$position          = 50;
    add_menu_page(
        'WooCommerce Custom Product Forms', //Required. Text in browser title bar when the page associated with this menu item is displayed.
        'HAM', //Required. Text to be displayed in the menu.
        'manage_options', //Required. The required capability of users to access this menu item.
        'wccpf-the-options', //Required. A unique identifier to identify this menu item.
        $pluginOptionsPage, //Optional. This callback outputs the content of the page associated with this menu item.
        $icon, //Optional. The URL to the menu item icon.
        $position //Optional. Position of the menu item in the menu.
    );

}

function wccpf_options_page()
{
    ?>
        <div class="wccpf-admin-form-wrap">
        <div id="icon-options-general" class="icon32"></div>
        <h1>WCCPF HAM Options</h1>
        <form method="post" action="options.php">
            <?php
           
                //add_settings_section callback is displayed here. For every new section we need to call settings_fields.
                settings_fields('header_section');
                settings_fields('fresh_meat_section');
                
               
                // all the add_settings_field callbacks is displayed here
                do_settings_sections('wccpf-options');
           
                // Add the submit button to serialize the options
                submit_button();
               
            ?>         
        </form>
    </div>
    <?php
}

//this action callback is triggered when wordpress is ready to add new items to menu.
add_action('admin_menu', 'add_new_menu_items');
add_action('woocommerce_before_add_to_cart_button', 'action_get_those_prod_cats', 51);
// check in wccpf-do.php to get this function working
add_action( 'woocommerce_add_to_cart_validation', 'wccpf_field_validation', 10, 5 );
add_action( 'woocommerce_add_to_cart', 'wccpf_save_fields', 1, 5 );
add_action( 'woocommerce_checkout_update_order_meta', 'wccpf_checkout_field_update_order_meta', 52);
add_filter( 'woocommerce_cart_item_name', 'wccpf_render_meta_on_cart_item', 10, 3 );
/*
add_action( 'woocommerce_add_to_cart', 'save_wccpf_name_field', 1, 5 );
add_filter( 'woocommerce_cart_item_name', 'render_wccpf_meta_on_cart_item', 1, 3 );
*/

/*WordPress Settings API*/
function display_options() {
    //section name, display name, callback to print description of section, page to which section is attached.
    add_settings_section("header_section", "HAM Options", "display_header_options_content", "wccpf-options");
    
    add_settings_section("fresh_meat_section", "WCCPF Options", "display_fresh_meat_section_options_content", "wccpf-options");    

    //setting name, display name, callback to print form element, page in which field is displayed, section to which it belongs.
    //id and name of form element should be same as the setting name.
    //last field section is optional.
    add_settings_field("wccpf_form_field_1", "Shower Cat, CF7 form [shortcode]:", "display_form_1", "wccpf-options", "header_section");
    add_settings_field("wccpf_form_field_2", "Birthday, CF7 form [shortcode]:", "display_form_2", "wccpf-options", "header_section");
    add_settings_field("wccpf_form_field_3", "Baseball CF7 form [shortcode]:", "display_form_3", "wccpf-options", "header_section");
    add_settings_field("wccpf_form_field_4", "Soccer CF7 form [shortcode]:", "display_form_4", "wccpf-options", "header_section");
    add_settings_field("wccpf_form_field_5", "Baseball Penant CF7 form [shortcode]:", "display_form_5", "wccpf-options", "header_section");
    add_settings_field("wccpf_form_field_6", "Softball Penant CF7 form [shortcode]:", "display_form_6", "wccpf-options", "header_section");

    add_settings_field("wccpf_form_field_meat", "FreshMeatSection [shortcode]:", "display_form_meat", "wccpf-options", "fresh_meat_section");
    include('inc/frags/wccpf-get-cats.php');
    $numOfFields = count($secondary_cats);
    $hamFieldCount = 0;
	while($hamFieldCount < $numOfFields) {	
		$hamFieldName = 'ham_form_field_'.$hamFieldCount;
		add_settings_field($hamFieldName, $hamFieldName.' <pre>'.$secondary_cat_names[$hamFieldCount].'</pre>[shortcode]:', "display_ham_fields", "wccpf-options", "fresh_meat_section", $hamFieldCount);
		register_setting("fresh_meat_section", $hamFieldName, $hamFieldCount);
		$hamFieldCount++;
	}
	
    //section name, form element name, callback for sanitization
    register_setting("header_section", "wccpf_form_field_1");
    register_setting("header_section", "wccpf_form_field_2");
    register_setting("header_section", "wccpf_form_field_3");
    register_setting("header_section", "wccpf_form_field_4");
    register_setting("header_section", "wccpf_form_field_5");
    register_setting("header_section", "wccpf_form_field_6");
    
    register_setting("fresh_meat_section", "wccpf_form_field_meat");
    
    //register css
//     wp_register_style( 'wccpfadminstyles', plugin_dir_url('/ham/wccpf.css') );
    wp_register_style('wccpfadminstyles', 'http://www.shopblackline.com/wp-content/plugins/ham/wccpf.css');
	wp_enqueue_style('wccpfadminstyles');
	
	//
/*
	add_action('wp_enqueue_scripts', 'wccpfbitchnstyles');
	function wccpfbitchnstyles() {
	    wp_register_style( 'wccpfstylenamespace', 'http://www.shopblackline.com/wp-content/plugins/ham/wccpf.css' );
	    wp_enqueue_style( 'wccpfstylenamespace' );
	    wp_enqueue_script( 'namespaceformyscript', 'http://locationofscript.com/myscript.js', array( 'jquery' ) );
	    wp_enqueue_script('wccpfadminscripts', 'http://www.shopblackline.com/wp-content/plugins/ham/wccpf.js', array( 'jquery' ) );    
	}
*/
	//
}

function display_header_options_content(){
	echo "THE header of the wccpf";
	// Creating an object instance of the product
	$_product = new WC_Product( $product_id );
	
	// getting the defined product attributes
	$product_attr = $_product->get_attributes();
	
	// displaying the array of values (just to test and to see output)
	echo '<pre>'.$_product.'</pre>';
	//include secondary prod cat names
/*
	include 'inc/prod-cat-list.php';
	foreach ($all_categories as $cat) {		
		if(in_array($cat->term_id, $secondary_cats)) {
			echo '<h3 style="color:cornflowerblue;">' . $cat->name . '</h3>';	
		}
	}
*/
}

function display_fresh_meat_section_options_content(){
	echo "The header for wccpf<br />";
	include 'inc/prod-cat-list.php';
	include('inc/frags/wccpf-admin-input-fields.php');
	//include('inc/frags/test.php');
	echo 'Number of Secondary Categories: ' . count($secondary_cats);
}
/*
function display_form(x)
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_"+x id="wccpf_form_field_"+x value="<?php echo esc_attr(get_option('wccpf_form_field_'+x)); ?>" />
    <?php
}
*/
function display_form_1()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_1" id="wccpf_form_field_1" value="<?php echo esc_attr(get_option('wccpf_form_field_1')); ?>" />
    <?php
}
function display_form_2()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_2" id="wccpf_form_field_2" value="<?php echo esc_attr(get_option('wccpf_form_field_2')); ?>" />
    <?php
}
function display_form_3()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_3" id="wccpf_form_field_3" value="<?php echo esc_attr(get_option('wccpf_form_field_3')); ?>" />
    <?php
}
function display_form_4()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_4" id="wccpf_form_field_4" value="<?php echo esc_attr(get_option('wccpf_form_field_4')); ?>" />
    <?php
}
function display_form_5()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_5" id="wccpf_form_field_5" value="<?php echo esc_attr(get_option('wccpf_form_field_5')); ?>" />
    <?php
}
function display_form_6()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_6" id="wccpf_form_field_6" value="<?php echo esc_attr(get_option('wccpf_form_field_6')); ?>" />
    <?php
}

include 'inc/wccpf-do.php';

//this action is executed after loads its core, after registering all actions, finds out what page to execute and before producing the actual output(before calling any action callback)
add_action("admin_init", "display_options");
// add_action( 'woocommerce_checkout_update_order_meta', 'wccpf_checkout_field_update_order_meta' );
/*
add_action( 'woocommerce_add_to_cart', 'save_wccpf_name_field', 1, 5 );
add_filter( 'woocommerce_cart_item_name', 'render_wccpf_meta_on_cart_item', 1, 3 );
*/