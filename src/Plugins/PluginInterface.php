<?php


namespace Phalyfusion\Plugins;

use Phalyfusion\Model\PluginOutput;

/**
 * Interface PluginInterface
 * @package Phalyfusion\Plugins
 */
interface PluginInterface
{
    /**
     * @return string
     */
    public static function get_name();

    /**
     * @param string $run_command
     */
    public function __construct($run_command);

    /**
     * @return PluginOutput
     */
    public function run();

}