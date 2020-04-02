<?php


namespace Plugins;


/**
 * Interface PluginInterface
 * @package Plugins
 */
interface PluginInterface  #TODO: func run, return PluginOutput.
{
    /**
     * @return string
     */
    public static function get_name();

    /**
     * @param string $run_command
     */
    public function __construct($run_command);

}