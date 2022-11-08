<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

global $wpdb;

$sql = "INSERT INTO wp_access values (default,'9.9.9.9','2022-11-06 17:03:15')";

dbDelta($sql);