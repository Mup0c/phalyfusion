<?php


namespace Phalyfusion\Plugins;


use Symfony\Component\Process\Process;

/**
 * Class PluginRunner.
 * Base class of plugin runner classes.
 * @package Plugins
 */
abstract class PluginRunner
{
    /**
     * @param string $runCommand
     */
    public function run(string $runCommand)
    {
        // TODO: Зафорсить формат вывода.
        $process = new Process(explode(' ', $runCommand));
        $process->run();
        $name = $this::getName();
        echo("\n---$name--- \n");
        echo $process->getErrorOutput();
        echo $process->getOutput();
    }

}