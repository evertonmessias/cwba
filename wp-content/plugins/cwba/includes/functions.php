<?php

//***************** Add General Configuration Roles
function general_configuration_role_caps()
{
	$roles = array('editor');
	foreach ($roles as $the_role) {
		$role = get_role($the_role);
		$role->remove_cap('list_users');
		$role->remove_cap('create_users');
		$role->remove_cap('remove_users');
		$role->remove_cap('promote_users');
		$role->remove_cap('edit_users');
		$role->add_cap('manage_options');
		//for woocommerce
		$role->add_cap("manage_woocommerce");
		$role->add_cap("view_woocommerce_reports");
		$role->add_cap("edit_product");
		$role->add_cap("read_product");
		$role->add_cap("delete_product");
		$role->add_cap("edit_products");
		$role->add_cap("edit_others_products");
		$role->add_cap("publish_products");
		$role->add_cap("read_private_products");
		$role->add_cap("delete_products");
		$role->add_cap("delete_private_products");
		$role->add_cap("delete_published_products");
		$role->add_cap("delete_others_products");
		$role->add_cap("edit_private_products");
		$role->add_cap("edit_published_products");
		$role->add_cap("manage_product_terms");
		$role->add_cap("edit_product_terms");
		$role->add_cap("delete_product_terms");
		$role->add_cap("assign_product_terms");
		$role->add_cap("edit_shop_order");
		$role->add_cap("read_shop_order");
		$role->add_cap("delete_shop_order");
		$role->add_cap("edit_shop_orders");
		$role->add_cap("edit_others_shop_orders");
		$role->add_cap("publish_shop_orders");
		$role->add_cap("read_private_shop_orders");
		$role->add_cap("delete_shop_orders");
		$role->add_cap("delete_private_shop_orders");
		$role->add_cap("delete_published_shop_orders");
		$role->add_cap("delete_others_shop_orders");
		$role->add_cap("edit_private_shop_orders");
		$role->add_cap("edit_published_shop_orders");
		$role->add_cap("manage_shop_order_terms");
		$role->add_cap("edit_shop_order_terms");
		$role->add_cap("delete_shop_order_terms");
		$role->add_cap("assign_shop_order_terms");
		$role->add_cap("edit_shop_coupon");
		$role->add_cap("read_shop_coupon");
		$role->add_cap("delete_shop_coupon");
		$role->add_cap("edit_shop_coupons");
		$role->add_cap("edit_others_shop_coupons");
		$role->add_cap("publish_shop_coupons");
		$role->add_cap("read_private_shop_coupons");
		$role->add_cap("delete_shop_coupons");
		$role->add_cap("delete_private_shop_coupons");
		$role->add_cap("delete_published_shop_coupons");
		$role->add_cap("delete_others_shop_coupons");
		$role->add_cap("edit_private_shop_coupons");
		$role->add_cap("edit_published_shop_coupons");
		$role->add_cap("manage_shop_coupon_terms");
		$role->add_cap("edit_shop_coupon_terms");
		$role->add_cap("delete_shop_coupon_terms");
		$role->add_cap("assign_shop_coupon_terms");
		$role->add_cap("edit_shop_webhook");
		$role->add_cap("read_shop_webhook");
		$role->add_cap("delete_shop_webhook");
		$role->add_cap("edit_shop_webhooks");
		$role->add_cap("edit_others_shop_webhooks");
		$role->add_cap("publish_shop_webhooks");
		$role->add_cap("read_private_shop_webhooks");
		$role->add_cap("delete_shop_webhooks");
		$role->add_cap("delete_private_shop_webhooks");
		$role->add_cap("delete_published_shop_webhooks");
		$role->add_cap("delete_others_shop_webhooks");
		$role->add_cap("edit_private_shop_webhooks");
		$role->add_cap("edit_published_shop_webhooks");
		$role->add_cap("manage_shop_webhook_terms");
		$role->add_cap("edit_shop_webhook_terms");
		$role->add_cap("delete_shop_webhook_terms");
		$role->add_cap("assign_shop_webhook_terms");		
	}
}
add_action('admin_init', 'general_configuration_role_caps', 999);


//***************** Add Remove menu page Admin
function wpdocs_remove_menus()
{
	if (current_user_can('editor')) {
		remove_menu_page('index.php'); //Dashboard		
		remove_menu_page('themes.php'); //Appearance
		remove_menu_page('edit-comments.php');
		remove_menu_page('plugins.php'); //Plugins
		remove_menu_page('users.php'); //Users
		remove_menu_page('tools.php'); //Tools
		remove_menu_page('options-general.php'); //Settings
		remove_menu_page('woocommerce'); // Woocommerce
	}
}
add_action('admin_menu', 'wpdocs_remove_menus');


// ***************** Add style & script for Admin
function style_and_script()
{
?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<?php
	wp_enqueue_style('stilos', '/wp-content/plugins/cwba/assets/cwba.css');
	wp_enqueue_script('scripts', '/wp-content/plugins/cwba/assets/cwba.js');
}
add_action('admin_enqueue_scripts', 'style_and_script');

//Rename menu iten Admin
function wd_admin_menu_rename1()
{
	global $menu;
	$menu[5][0] = 'Blog';
}
add_action('admin_menu', 'wd_admin_menu_rename1');

function wd_admin_menu_rename2()
{
	global $menu, $submenu;
    $menu[26][0] = 'Cursos';
    $submenu['edit.php?post_type=product'][5][0] = 'Todos os Cursos';
}
add_action('admin_menu', 'wd_admin_menu_rename2');


// ***************** Add About in Menu
function menu_cursos()
{
	add_submenu_page('options-general.php', 'Sobre CWBA', 'Sobre CWBA', 'edit_posts', 'about', 'function_about', 2);
}
add_action('admin_menu', 'menu_cursos');

// ***************** Add About
function function_about()
{
	include ABSPATH . '/wp-content/plugins/cwba/includes/about.php';
}
add_action('function_about', 'function_about');


// ***************** Add Media
function load_media_files()
{
	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_media_files');


//************* Add thumbnails
add_theme_support('post-thumbnails', array('cursos'));


//************* Removes categories from Posts (do after register category name)
function remove_categories() {
    unregister_taxonomy_for_object_type( 'category', 'post' );
}
add_action( 'init', 'remove_categories' );

function registerdb($ip) // register in db
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'access';
	$resp = $wpdb->insert($table_name, array('ipadress' => $ip, 'time' => current_time('mysql')));
	if ($resp == 1) {
		return "register db: SUCESS";
	} else {
		return "register db: ERROR";
	}
}
add_action('registerdb','registerdb');


function list_access($item) // list access
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'access';
	$results = $wpdb->get_results(
		"SELECT $item FROM $table_name"
	);
	return $results;
}
add_action('list_access','list_access');
