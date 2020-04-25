<?php


namespace Phalyfusion\Model;


/**
 * Class PluginOutput
 * Model presenting output of the plugin
 * @package Phalyfusion\Model
 */
class PluginOutput
{
    /**
     * @var string
     */
    public string $output;

    /**
     * PluginOutput constructor.
     * @param string $output
     */
    public function __construct(string $output)
    {
        $this->output = $output;
    }
}