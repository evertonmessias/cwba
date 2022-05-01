<?php

namespace FcfVendor\WPDesk\License\Page;

use FcfVendor\WPDesk\License\Page\License\Action\LicenseActivation;
use FcfVendor\WPDesk\License\Page\License\Action\LicenseDeactivation;
use FcfVendor\WPDesk\License\Page\License\Action\Nothing;
/**
 * Action factory.
 *
 * @package WPDesk\License\Page\License
 */
class LicensePageActions
{
    /**
     * Creates action object according to given param
     *
     * @param string $action
     *
     * @return Action
     */
    public function create_action($action)
    {
        if ($action === 'activate') {
            return new \FcfVendor\WPDesk\License\Page\License\Action\LicenseActivation();
        }
        if ($action === 'deactivate') {
            return new \FcfVendor\WPDesk\License\Page\License\Action\LicenseDeactivation();
        }
        return new \FcfVendor\WPDesk\License\Page\License\Action\Nothing();
    }
}
