<?php

namespace FcfVendor\WPDesk\Composer\Codeception;

use FcfVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests;
use FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb;
use FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests;
use FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage;
use FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests;
use FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception;
use FcfVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests;
use FcfVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests;
use FcfVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage;
/**
 * Links plugin commands handlers to composer.
 */
class CommandProvider implements \FcfVendor\Composer\Plugin\Capability\CommandProvider
{
    public function getCommands()
    {
        return [new \FcfVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage(), new \FcfVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests()];
    }
}
