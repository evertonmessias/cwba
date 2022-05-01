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

// FUNCTIONS ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/functions.php';

// SETTINGS ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/settings.php';

// POSTMETA POST ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/postmeta-post.php';

// POSTMETA PRODUCT ************************************************
include ABSPATH . '/wp-content/plugins/cwba/includes/postmeta-product.php';
