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
     * ErrorModel constructor.
     * @param int $line
     * @param string $message
     * @param string $type
     */
    public function __construct(int $line, string $message, string $type)
    {
        $this->line = $line;
        $this->message = $message;
        $this->type = $type;
    }

}