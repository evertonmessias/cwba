<?php

//Functions cwba

//*************URL theme [ get_template_directory_uri() ]
define('SITEPATH', '/wp-content/themes/cwba/');


//************* Login_redirect
function admin_default_page()
{
  return '/cursos';
}
add_filter('login_redirect', 'admin_default_page');


//************* Admin Login Logo
function tf_wp_admin_login_logo()
{ ?>
  <style type="text/css">
    #login {
      margin-top: 50px !important;
      background-color: #fff;
      padding: 0% 0 0 !important;
      padding: 20px !important;
      box-shadow: 0 0 15px rgb(0, 0, 0, 0.8) !important;
      border-radius: 5px;
    }

    #login h1 a {
      background-image: url('<?php echo get_option('home_input_2'); ?>');
      background-size: 150px;
      width: 150px;
      height: 130px;
    }

    #login .galogin-powered {
      display: none;
    }

    .language-switcher {
      display: none;
    }
  </style>
<?php }
add_action('login_enqueue_scripts', 'tf_wp_admin_login_logo');


//************* Admin Login Logo Link URL
function tf_wp_admin_login_logo_url()
{
  return home_url();
}
add_filter('login_headerurl', 'tf_wp_admin_login_logo_url');


//************* Admin Login Logo's Title
function tf_wp_admin_login_logo_title($headertext)
{
  $headertext = esc_html__(get_bloginfo('name'), 'plugin-textdomain');
  return $headertext;
}
add_filter('login_headertext', 'tf_wp_admin_login_logo_title');


//************ Hide admin bar for customer
function hide_admin_bar()
{
  if (is_user_logged_in()) {
    if (current_user_can('customer')) {
      echo "bar-logged-customer";
    } else {
      echo "bar-logged";
    }
  }
}
add_action('hide_admin_bar', 'hide_admin_bar');


//************* URL from breadcrumbs
function url_active()
{
  return explode("/", $_SERVER['REQUEST_URI']);
}
add_action('url_active', 'url_active');


//************* Remove tags support from posts
function myprefix_unregister_tags()
{
  unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');


//************* Add thumbnails
add_theme_support('post-thumbnails', array('post'));


//************* Customer Orders
function customer_orders($user_id, $curso_id)
{
  $customer_orders = wc_get_orders(['customer_id' => $user_id]);
  $item_count = 0;
  $array_item = array();
  $array_status = array();
  foreach ($customer_orders as $customer_order) {
    $item_count += $customer_order->get_total();
    $array_status[] = $customer_order->get_status();
    foreach ($customer_order->get_items() as $item) {
      $array_item[] = $item;
    }
  }
  for ($x = 0; $x < $item_count; $x++) {
    if ($array_item[$x]['product_id'] == $curso_id && $array_status[$x] == "completed") {
      return 2; // ok
    } elseif ($array_item[$x]['product_id'] == $curso_id && $array_status[$x] == "processing") {
      return 1; // processing
    } else {
      return 0; // off
    }
  }
}
add_action('customer_orders', 'customer_orders');
