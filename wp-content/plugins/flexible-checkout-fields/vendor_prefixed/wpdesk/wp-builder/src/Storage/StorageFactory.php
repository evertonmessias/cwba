<?php

namespace FcfVendor\WPDesk\PluginBuilder\Storage;

class StorageFactory
{
    /**
     * @return PluginStorage
     */
    public function create_storage()
    {
        return new \FcfVendor\WPDesk\PluginBuilder\Storage\WordpressFilterStorage();
    }
}
