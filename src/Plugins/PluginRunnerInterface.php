<?php


namespace Phalyfusion\Plugins;

use Phalyfusion\Model\PluginOutputModel;

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
     * @return PluginOutputModel
     */
    public function run(string $runCommand): PluginOutputModel;

}