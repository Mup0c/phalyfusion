<?php


namespace Phalyfusion\Plugins\Psalm;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Phalyfusion\Plugins\PluginInterface;

/**
 * Class PsalmRunner
 * @package Phalyfusion\Plugins\Psalm
 */
class PsalmRunner implements PluginInterface
{
    private const name = "psalm";

    /**
     * @var string
     */
    private string $run_command;

    /**
     * PsalmRunner constructor.
     * @param string $run_command
     */
    public function __construct($run_command)
    {
        echo("Hello, Psalm!\n");
        $this->run_command = $run_command;
    }

    /**
     * @inheritDoc
     */
    public static function get_name()
    {
        return self::name;
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        // TODO: Implement run() method.
    }
}