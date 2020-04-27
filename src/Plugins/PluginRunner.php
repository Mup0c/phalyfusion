<?php


namespace Phalyfusion\Plugins;


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
    abstract public static function getName(): string;

    /**
     * Prepares given command. Makes output parseable.
     * @param string $runCommand
     * @return string
     */
    abstract protected function prepareCommand(string $runCommand): string;

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
     * @return PluginOutputModel
     */
    public function run(string $runCommand): PluginOutputModel
    {
        $process = Process::fromShellCommandline($this->prepareCommand($runCommand));
        $process->run();
        $output = $process->getOutput();

        $name = $this::getName();
        echo("\n---$name--- \n");
        #echo $process->getErrorOutput(); #phpstan тэги есть, внутри пусто, phan psalm пустая строка
        echo $process->getErrorOutput(); #TODO: real-time output or progress bar
        $a = $process->getErrorOutput();

        return $this->parseOutput($output);
    }

}