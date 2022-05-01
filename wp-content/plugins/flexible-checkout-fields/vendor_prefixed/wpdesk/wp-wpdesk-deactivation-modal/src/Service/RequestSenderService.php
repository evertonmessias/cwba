<?php

namespace FcfVendor\WPDesk\DeactivationModal\Service;

use FcfVendor\WPDesk\DeactivationModal\Exception\SenderRequestFailedException;
use FcfVendor\WPDesk\DeactivationModal\Hookable;
use FcfVendor\WPDesk\DeactivationModal\Model\FormOptions;
use FcfVendor\WPDesk\DeactivationModal\Model\FormValues;
use FcfVendor\WPDesk\DeactivationModal\Model\RequestData;
use FcfVendor\WPDesk\DeactivationModal\Sender\Sender;
/**
 * Sends the report about the plugin deactivation.
 */
class RequestSenderService implements \FcfVendor\WPDesk\DeactivationModal\Hookable
{
    const FORM_FIELD_REASON = '_deactivation_reason';
    const FORM_FIELD_MESSAGE = '_deactivation_message_%s';
    const ADMIN_AJAX_ACTION = 'wpdesk_deactivation_request_';
    const ADMIN_AJAX_NONCE = 'wpdesk-deactivation-request';
    /**
     * @var string
     */
    private $plugin_slug;
    /**
     * @var FormOptions
     */
    private $form_options;
    /**
     * @var FormValues
     */
    private $form_values;
    /**
     * @var Sender
     */
    private $request_sender;
    public function __construct(string $plugin_slug, \FcfVendor\WPDesk\DeactivationModal\Model\FormOptions $form_options, \FcfVendor\WPDesk\DeactivationModal\Model\FormValues $form_values, \FcfVendor\WPDesk\DeactivationModal\Sender\Sender $request_sender)
    {
        $this->plugin_slug = $plugin_slug;
        $this->form_options = $form_options;
        $this->form_values = $form_values;
        $this->request_sender = $request_sender;
    }
    /**
     * {@inheritdoc}
     */
    public function hooks()
    {
        \add_action('wp_ajax_' . self::ADMIN_AJAX_ACTION . $this->plugin_slug, [$this, 'handle_ajax_request']);
        \add_action('wp_ajax_nopriv_' . self::ADMIN_AJAX_ACTION . $this->plugin_slug, [$this, 'handle_ajax_request']);
    }
    public static function generate_ajax_url(string $plugin_slug) : string
    {
        return \sprintf('admin-ajax.php?action=%1$s&nonce=%2$s', self::ADMIN_AJAX_ACTION . $plugin_slug, \wp_create_nonce(self::ADMIN_AJAX_NONCE));
    }
    /**
     * @param mixed|null $request_params .
     *
     * @throws SenderRequestFailedException
     * @internal
     */
    public function handle_ajax_request($request_params = null)
    {
        $params = $request_params && \is_array($request_params) ? $request_params : \wp_unslash($_REQUEST);
        if (\wp_verify_nonce($params['nonce'] ?? '', self::ADMIN_AJAX_NONCE) !== \false) {
            $this->send_request($params);
            \wp_send_json_success();
        } else {
            \wp_send_json_error();
        }
        \wp_die();
    }
    /**
     * @param array $request_params .
     *
     * @return void
     *
     * @throws SenderRequestFailedException
     */
    private function send_request(array $request_params)
    {
        $request_data = $this->get_request_data($request_params);
        $this->request_sender->send_request($request_data);
    }
    private function get_request_data(array $request_params) : \FcfVendor\WPDesk\DeactivationModal\Model\RequestData
    {
        $request_data = (new \FcfVendor\WPDesk\DeactivationModal\Model\RequestData($this->plugin_slug))->set_reason_key($this->get_deactivation_reason($request_params));
        if ($request_data->get_reason_key() !== null) {
            $value_key = \sprintf(self::FORM_FIELD_MESSAGE, $request_data->get_reason_key());
            $request_data->set_additional_info(isset($request_params[$value_key]) ? \sanitize_textarea_field($request_params[$value_key]) : null);
        }
        foreach ($this->form_values->get_values() as $value) {
            $request_data->set_additional_data_item($value->get_key(), \call_user_func($value->get_value_callback()));
        }
        return $request_data;
    }
    /**
     * @param array $request_params .
     *
     * @return string|null
     */
    private function get_deactivation_reason(array $request_params)
    {
        $request_reason = $request_params[self::FORM_FIELD_REASON] ?? '';
        foreach ($this->form_options->get_options() as $option) {
            if ($option->get_key() === $request_reason) {
                return $request_reason;
            }
        }
        return null;
    }
}
