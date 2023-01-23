<?php

/**
 * Plugin Name: CWBA
 * Plugin URI: https://ic.unicamp.br/~everton
 * Description: Plugin para gerenciamento do site CWBA
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

    $table_name2 = $wpdb->prefix . 'login';
    $sql = "CREATE TABLE $table_name2 (`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT, `user` text NOT NULL,`ipadress` text NOT NULL,`time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL)$charset_collate;";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name2'") != $table_name2) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    //remove_role('contributor');
    //remove_role('customer');
    //remove_role('author');
    //remove_role( 'shop_manager' );
    //add_role( 'aluno', 'Aluno', array( 'read' => true, 'level_0' => true ) );
    flush_rewrite_rules();
    
}
register_activation_hook(__FILE__, 'add_db_access');


// DEACTIVATE *************************************************
function deactivate()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'deactivate');


// FUNCTIONS ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/functions.php';

// SETTINGS ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/settings.php';

// POSTMETA ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/post.php';
