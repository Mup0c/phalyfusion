<?php


namespace Phalyfusion\Model;


/**
 * Class PluginOutput
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