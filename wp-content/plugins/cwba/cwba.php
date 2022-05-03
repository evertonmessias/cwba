<?php

/**
 * Plugin Name: CWBA
 * Plugin URI: https://ic.unicamp.br/~everton
 * Description: Plugin CWBA
 * Author: EvM.
 * Version: 1.0
 * Text Domain: CWBA
 * Plugin CWBA
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// ***************** Add DB
function add_db_access()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'access';
    $sql = "CREATE TABLE $table_name (`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,`ipadress` text NOT NULL,`time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL)$charset_collate;";

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'add_db_access');


// FUNCTIONS ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/functions.php';

// SETTINGS ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/settings.php';

// POSTMETA POST ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/postmeta-post.php';

// POSTMETA PRODUCT ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/postmeta-product.php';
