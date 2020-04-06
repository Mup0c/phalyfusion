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
    public static function getName();

    /**
     * @return PluginOutput
     */
    public function run();

}