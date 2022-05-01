<?php

namespace FcfVendor\WPDesk\Helper;

use Psr\Log\LoggerInterface;
use FcfVendor\WPDesk\Helper\Debug\LibraryDebug;
use FcfVendor\WPDesk\Helper\Integration\LicenseIntegration;
use FcfVendor\WPDesk\Helper\Integration\LogsIntegration;
use FcfVendor\WPDesk\Helper\Integration\SettingsIntegration;
use FcfVendor\WPDesk\Helper\Integration\TrackerIntegration;
use FcfVendor\WPDesk\Helper\Logs\LibraryInfoProcessor;
use FcfVendor\WPDesk\Helper\Page\LibraryDebugPage;
use FcfVendor\WPDesk\Helper\Page\SettingsPage;
use FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable;
/**
 * Manager all functionalities understood as helper
 *
 * @package WPDesk\Helper
 */
class PrefixedHelperAsLibrary implements \FcfVendor\WPDesk\PluginBuilder\Plugin\Hookable
{
    const LIBRARY_TEXT_DOMAIN = 'flexible-checkout-fields';
    const MAIN_WPDESK_MENU_POSITION = 99.99941337;
    const PRIORITY_AFTER_WPDESK_MENU_REMOVAL = 15;
    const PRIORITY_AFTER_ALL = 200;
    /** @var LoggerInterface */
    private static $logger;
    /** @var \WPDesk_Tracker */
    private static $tracker;
    public function hooks()
    {
        if (\is_admin() && !$this->is_already_hooked_touch()) {
            $this->initialize();
            \do_action('wpdesk_helper_initialized', $this);
        }
    }
    /**
     * Check if prefixed helpers is not already hooked. Also touch flag so we know that is hooked now
     *
     * @return bool
     */
    private function is_already_hooked_touch()
    {
        $is_loaded = \apply_filters('wpdesk_prefixed_helper_is_loaded', \false);
        \add_filter('wpdesk_prefixed_helper_is_loaded', function () {
            return \true;
        });
        return $is_loaded;
    }
    /**
     * Show info about installed helper plugin
     */
    private function show_notices_about_old_helper()
    {
        $helper_info = new \FcfVendor\WPDesk\Helper\HelperRemoveInfo();
        if ($helper_info->is_helper_active()) {
            $helper_info->show_deactivate_helper_notice();
        } elseif ($helper_info->is_helper_installed()) {
            $helper_info->show_remove_helper_notice();
        }
    }
    private function initialize()
    {
        $this->add_wpdesk_menu();
        $subscription_integration = new \FcfVendor\WPDesk\Helper\Integration\LicenseIntegration();
        $subscription_integration->hooks();
        $settingsPage = new \FcfVendor\WPDesk\Helper\Page\SettingsPage();
        $settings_integration = new \FcfVendor\WPDesk\Helper\Integration\SettingsIntegration($settingsPage);
        $tracker_integration = new \FcfVendor\WPDesk\Helper\Integration\TrackerIntegration($settingsPage);
        $logger_integration = new \FcfVendor\WPDesk\Helper\Integration\LogsIntegration($settingsPage);
        $settings_integration->add_hookable($logger_integration);
        $settings_integration->add_hookable($tracker_integration);
        $settings_integration->hooks();
        self::$tracker = $tracker_integration->get_tracker();
        self::$logger = $logger_integration->get_logger();
        (new \FcfVendor\WPDesk\Helper\UpgradeSoonNotice())->show_info_about_upgrade_if_old_env();
        $this->clean_wpdesk_menu();
        $library_debug_info = new \FcfVendor\WPDesk\Helper\Debug\LibraryDebug();
        (new \FcfVendor\WPDesk\Helper\Page\LibraryDebugPage($library_debug_info))->hooks();
        self::$logger->pushProcessor(new \FcfVendor\WPDesk\Helper\Logs\LibraryInfoProcessor($library_debug_info));
        $this->show_notices_about_old_helper();
    }
    /**
     * Adds WP Desk to main menu
     */
    private function add_wpdesk_menu()
    {
        \add_action('admin_menu', function () {
            $this->handle_add_wpdesk_menu();
        }, self::PRIORITY_AFTER_WPDESK_MENU_REMOVAL);
    }
    /**
     * @return void
     */
    private function handle_add_wpdesk_menu()
    {
        \add_menu_page('WP Desk', 'WP Desk', 'manage_options', 'wpdesk-helper', function () {
        }, 'dashicons-controls-play', self::MAIN_WPDESK_MENU_POSITION);
    }
    /**
     * Removed unnecessary submenu item for WP Desk
     */
    private function clean_wpdesk_menu()
    {
        \add_action('admin_menu', static function () {
            \remove_submenu_page('wpdesk-helper', 'wpdesk-helper');
        }, self::PRIORITY_AFTER_ALL);
    }
    /**
     * @return \WPDesk_Tracker
     */
    public function get_tracker()
    {
        return self::$tracker;
    }
    /**
     * @return LoggerInterface
     */
    public function get_logger()
    {
        return self::$logger;
    }
}
