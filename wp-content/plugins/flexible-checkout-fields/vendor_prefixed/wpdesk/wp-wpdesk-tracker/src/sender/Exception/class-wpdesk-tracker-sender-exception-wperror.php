<?php

namespace FcfVendor;

if (!\defined('ABSPATH')) {
    exit;
}
if (!\class_exists('FcfVendor\\WPDesk_Tracker_Sender_Exception_WpError')) {
    class WPDesk_Tracker_Sender_Exception_WpError extends \RuntimeException
    {
        public function __construct($message = "", \WP_Error $wp_error)
        {
            $message = $message . ' WP_Error: ' . $wp_error->get_error_message();
            parent::__construct($message, $wp_error->get_error_code());
        }
    }
}
