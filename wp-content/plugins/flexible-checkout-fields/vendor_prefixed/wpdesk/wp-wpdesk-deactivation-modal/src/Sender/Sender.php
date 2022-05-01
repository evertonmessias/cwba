<?php

namespace FcfVendor\WPDesk\DeactivationModal\Sender;

use FcfVendor\WPDesk\DeactivationModal\Exception\SenderRequestFailedException;
use FcfVendor\WPDesk\DeactivationModal\Model\RequestData;
interface Sender
{
    /**
     * @param RequestData $request_data .
     *
     * @return array
     */
    public function generate_request_data(\FcfVendor\WPDesk\DeactivationModal\Model\RequestData $request_data) : array;
    /**
     * @param RequestData $request_data .
     *
     * @return bool Request success status.
     *
     * @throws SenderRequestFailedException
     */
    public function send_request(\FcfVendor\WPDesk\DeactivationModal\Model\RequestData $request_data) : bool;
}
