<?php

namespace FcfVendor\WPDesk\Composer\Codeception\Commands;

use FcfVendor\Composer\Downloader\FilesystemException;
use FcfVendor\Symfony\Component\Console\Input\InputArgument;
use FcfVendor\Symfony\Component\Console\Input\InputInterface;
use FcfVendor\Symfony\Component\Console\Output\OutputInterface;
use FcfVendor\Symfony\Component\Yaml\Exception\ParseException;
use FcfVendor\Symfony\Component\Yaml\Yaml;
/**
 * Codeception tests run command.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
class PrepareLocalCodeceptionTestsWithCoverage extends \FcfVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests
{
    use LocalCodeceptionTrait;
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('prepare-local-codeception-tests-with-coverage')->setDescription('Prepare local codeception tests.');
    }
    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(\FcfVendor\Symfony\Component\Console\Input\InputInterface $input, \FcfVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->prepareLocalCodeceptionTests($input, $output, \true);
        $configuration = $this->getWpDeskConfiguration();
        $plugin_file = $configuration->getApacheDocumentRoot() . '/wp-content/plugins/' . $configuration->getPluginFile();
        \file_put_contents($plugin_file, "\ndefine('C3_CODECOVERAGE_ERROR_LOG_FILE', '/tmp/c3_error.log'); include __DIR__ . '/c3.php';", \FILE_APPEND);
    }
}
