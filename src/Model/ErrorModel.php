<?php


namespace Phalyfusion\Model;


/**
 * Class ErrorModel
 * Presenting error as fields that describe it
 * @package Phalyfusion\Model
 */
class ErrorModel
{

    /**
     * @var int
     */
    public int $line;

    /**
     * @var string
     */
    public string $message;

    /**
     * @var string
     */
    public string $type;

    /**
     * Name of the plugin that generated this error
     * @var string
     */
    public string $pluginName;

    /**
     * ErrorModel constructor.
     * @param int $line
     * @param string $message
     * @param string $type
     * @param string $pluginName
     */
    public function __construct(int $line, string $message, string $type, string $pluginName)
    {
        $this->line = $line;
        $this->message = $message;
        $this->type = $type;
        $this->pluginName = $pluginName;
    }

}