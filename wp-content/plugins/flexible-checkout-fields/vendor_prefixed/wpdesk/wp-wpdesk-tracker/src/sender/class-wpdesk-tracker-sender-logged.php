<?php

namespace FcfVendor;

if (!\defined('ABSPATH')) {
    exit;
}
if (!\class_exists('FcfVendor\\WPDesk_Tracker_Sender_Logged')) {
    class WPDesk_Tracker_Sender_Logged implements \WPDesk_Tracker_Sender
    {
        const LOGGER_SOURCE = 'wpdesk-sender';
        /**
         * Decorated sender.
         *
         * @var WPDesk_Tracker_Sender
         */
        private $sender;
        /**
         * WPDesk_Tracker_Sender_Logged constructor.
         *
         * @param WPDesk_Tracker_Sender $sender Sender to decorate.
         */
        public function __construct(\WPDesk_Tracker_Sender $sender)
        {
            $this->sender = $sender;
        }
        /**
         * Sends payload logging payload and the response.
         *
         * @param array $payload Payload to send.
         *
         * @throws WPDesk_Tracker_Sender_Exception_WpError Error if send failed.
         *
         * @return array If succeeded. Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
         */
        public function send_payload(array $payload)
        {
            if (\class_exists('FcfVendor\\WPDesk_Logger_Factory')) {
                \FcfVendor\WPDesk_Logger_Factory::log_message("Sender payload: " . \json_encode($payload), self::LOGGER_SOURCE, \FcfVendor\WPDesk_Logger::DEBUG);
                try {
                    $response = $this->sender->send_payload($payload);
                    \FcfVendor\WPDesk_Logger_Factory::log_message('Sender response: ' . \json_encode($response), self::LOGGER_SOURCE, \FcfVendor\WPDesk_Logger::DEBUG);
                    return $response;
                } catch (\FcfVendor\WPDesk_Tracker_Sender_Exception_WpError $exception) {
                    \FcfVendor\WPDesk_Logger_Factory::log_exception($exception);
                    throw $exception;
                }
            } else {
                return $this->sender->send_payload($payload);
            }
        }
    }
}
