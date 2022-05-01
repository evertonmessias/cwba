<?php

namespace FcfVendor\WPDesk\Composer\Codeception;

use FcfVendor\Composer\Composer;
use FcfVendor\Composer\IO\IOInterface;
use FcfVendor\Composer\Plugin\Capable;
use FcfVendor\Composer\Plugin\PluginInterface;
/**
 * Composer plugin.
 *
 * @package WPDesk\Composer\Codeception
 */
class Plugin implements \FcfVendor\Composer\Plugin\PluginInterface, \FcfVendor\Composer\Plugin\Capable
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var IOInterface
     */
    private $io;
    public function activate(\FcfVendor\Composer\Composer $composer, \FcfVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function deactivate(\FcfVendor\Composer\Composer $composer, \FcfVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function uninstall(\FcfVendor\Composer\Composer $composer, \FcfVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    public function getCapabilities()
    {
        return [\FcfVendor\Composer\Plugin\Capability\CommandProvider::class => \FcfVendor\WPDesk\Composer\Codeception\CommandProvider::class];
    }
}
