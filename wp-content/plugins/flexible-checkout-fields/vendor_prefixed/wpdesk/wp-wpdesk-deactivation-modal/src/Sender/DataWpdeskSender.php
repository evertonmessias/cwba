<?php

namespace FcfVendor\WPDesk\DeactivationModal\Sender;

use FcfVendor\WPDesk\DeactivationModal\Exception\SenderRequestFailedException;
use FcfVendor\WPDesk\DeactivationModal\Model\RequestData;
use WPDesk_Tracker_Sender;
use FcfVendor\WPDesk_Tracker_Sender_Wordpress_To_WPDesk;
/**
 * Sends a deactivation report to data.wpdesk.org.
 */
class DataWpdeskSender implements \FcfVendor\WPDesk\DeactivationModal\Sender\Sender
{
    const HOOK_TRACKER_DEACTIVATION_DATA = 'wpdesk_tracker_deactivation_data';
    const NO_REASON_CHOSEN_KEY = 'null';
    /**
     * @var string
     */
    private $plugin_file_name;
    /**
     * @var string
     */
    private $plugin_name;
    /**
     * @var WPDesk_Tracker_Sender
     */
    private $tracker_sender;
    /**
     * @param string $plugin_file_name Example: "plugin-name/plugin-name.php".
     * @param string $plugin_name      The full name of the plugin.
     */
    public function __construct(string $plugin_file_name, string $plugin_name)
    {
        $this->plugin_file_name = $plugin_file_name;
        $this->plugin_name = $plugin_name;
        $this->tracker_sender = new \FcfVendor\WPDesk_Tracker_Sender_Wordpress_To_WPDesk();
    }
    /**
     * {@inheritdoc}
     */
    public function generate_request_data(\FcfVendor\WPDesk\DeactivationModal\Model\RequestData $request_data) : array
    {
        $request_body = ['click_action' => 'plugin_deactivation', 'plugin' => $this->plugin_file_name, 'plugin_name' => $this->plugin_name, 'reason' => $request_data->get_reason_key() ?: self::NO_REASON_CHOSEN_KEY, 'additional_data' => $request_data->get_additional_data()];
        if ($request_data->get_additional_info() !== null && $request_data->get_additional_info() !== '') {
            $request_body['additional_info'] = $request_data->get_additional_info();
        }
        return \apply_filters(self::HOOK_TRACKER_DEACTIVATION_DATA, $request_body, $this->plugin_file_name);
    }
    /**
     * {@inheritdoc}
     *
     * @throws SenderRequestFailedException
     */
    public function send_request(\FcfVendor\WPDesk\DeactivationModal\Model\RequestData $request_data) : bool
    {
        try {
            $request_body = $this->generate_request_data($request_data);
            $response = $this->tracker_sender->send_payload($request_body);
            return \is_array($response);
        } catch (\Exception $e) {
            throw new \FcfVendor\WPDesk\DeactivationModal\Exception\SenderRequestFailedException($e->getMessage());
        }
    }
}
