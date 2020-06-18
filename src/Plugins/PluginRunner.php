<?php


namespace Phalyfusion\Plugins;


use Phalyfusion\Console\IOHandler;
use Phalyfusion\Model\PluginOutputModel;
use Symfony\Component\Process\Process;

/**
 * Class PluginRunner.
 * Base class of plugin runner classes.
 * @package Plugins
 */
abstract class PluginRunner implements PluginRunnerInterface
{

    /**
     * Name of particular plugin
     * @return string
     */
    public static function getName(): string
    {
        return static::name;
    }

    /**
     * Prepares given command line for running the plugin.
     * Adds 'paths to analyse' argument/option if it is provided to Phalyfusion.
     * Removes/modifies arguments/options/flags of the commend line to make output nice and parseable
     * and to avoid unwanted behavior of the plugin
     * @param string $runCommand
     * @param string[] $paths
     * @return string
     */
    abstract protected function prepareCommand(string $runCommand, array $paths): string;

    /**
     * Parse $output of particular plugin into PluginOutputModel.
     * @param string $output
     * @return PluginOutputModel
     */
    abstract protected function parseOutput(string $output): PluginOutputModel;

    /**
     * Adds $option to $runCommand before other options and arguments
     * @param string $runCommand
     * @param string $option
     * @return string
     */
    protected function addOption(string $runCommand, string $option): string
    {
        preg_match('/\'.*?\'|".*?"|\S+/', $runCommand, $matches);
        return substr_replace($runCommand, " $option", strlen($matches[0]),0);
    }

    /**
     * @param string $runCommand
     * @param string[] $paths
     * @return PluginOutputModel
     */
    public function run(string $runCommand, array $paths): PluginOutputModel
    {
        $name = $this::getName();
        $runCommand = $this->prepareCommand($runCommand, $paths);

        IOHandler::debug("---$name---");
        IOHandler::debug("$runCommand");

        $process = Process::fromShellCommandline($runCommand);
        try {
            $process->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    IOHandler::debug($buffer, false);
                }
            });
        } catch (\Exception $e) {
            IOHandler::error("$name run failed! Aborting.", $e);
            exit(1);
        }

        $output = $process->getOutput();
        if (!$output)
        {
            IOHandler::error("$name run seems to be failed! Empty output.", $process->getErrorOutput());
        }

        return $this->parseOutput($output);
    }

}