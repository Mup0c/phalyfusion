<?php


namespace Phalyfusion\Plugins;

use Phalyfusion\Model\PluginOutput;

/**
 * Interface PluginRunnerInterface
 * @package Phalyfusion\Plugins
 */
interface PluginRunnerInterface
{
    /**
     * @return string
     */
    public static function getName(): string;

    /**
     * @param string $runCommand
     * @return PluginOutput
     */
    public function run(string $runCommand): PluginOutput;

}