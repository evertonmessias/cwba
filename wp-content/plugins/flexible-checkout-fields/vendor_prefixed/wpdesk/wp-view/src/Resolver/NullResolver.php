<?php

namespace FcfVendor\WPDesk\View\Resolver;

use FcfVendor\WPDesk\View\Renderer\Renderer;
use FcfVendor\WPDesk\View\Resolver\Exception\CanNotResolve;
/**
 * This resolver never finds the file
 *
 * @package WPDesk\View\Resolver
 */
class NullResolver implements \FcfVendor\WPDesk\View\Resolver\Resolver
{
    public function resolve($name, \FcfVendor\WPDesk\View\Renderer\Renderer $renderer = null)
    {
        throw new \FcfVendor\WPDesk\View\Resolver\Exception\CanNotResolve("Null Cannot resolve");
    }
}
