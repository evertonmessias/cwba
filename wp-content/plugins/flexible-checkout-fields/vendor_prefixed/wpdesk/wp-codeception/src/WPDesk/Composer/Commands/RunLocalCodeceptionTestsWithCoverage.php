<?php

namespace FcfVendor\WPDesk\Composer\Codeception\Commands;

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
class RunLocalCodeceptionTestsWithCoverage extends \FcfVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests
{
    use LocalCodeceptionTrait;
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('run-local-codeception-tests-with-coverage')->setDescription('Run local codeception tests.')->setDefinition(array(new \FcfVendor\Symfony\Component\Console\Input\InputArgument(self::SINGLE, \FcfVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Name of Single test to run.', ' ')));
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
        $configuration = $this->getWpDeskConfiguration();
        $this->prepareWpConfig($output, $configuration);
        $singleTest = $input->getArgument(self::SINGLE);
        $sep = \DIRECTORY_SEPARATOR;
        $codecept = "vendor{$sep}bin{$sep}codecept";
        $cleanOutput = $codecept . ' clean';
        $this->execAndOutput($cleanOutput, $output);
        $runLocalTests = $codecept . ' run -f --steps --html --coverage --coverage-xml --coverage-html --verbose acceptance ' . $singleTest;
        $this->execAndOutput($runLocalTests, $output);
    }
}
