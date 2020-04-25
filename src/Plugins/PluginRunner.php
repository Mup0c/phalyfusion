<?php


namespace Phalyfusion\Plugins;


use Phalyfusion\Model\PluginOutput;
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
     * @return PluginOutput
     */
    public function run(string $runCommand): PluginOutput
    {
        #$process = new Process(explode(' ', $this->prepareCommand($runCommand))); #TODO: quotes and spaces support
        $process = Process::fromShellCommandline($this->prepareCommand($runCommand)); #todo DONE ?
        $process->run();

        $name = $this::getName();
        echo("\n---$name--- \n");
        echo $process->getErrorOutput();
        echo $process->getOutput();

        return new PluginOutput('kek');
    }

}