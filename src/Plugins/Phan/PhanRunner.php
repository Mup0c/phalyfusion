<?php


namespace Phalyfusion\Plugins\Phan;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Phalyfusion\Plugins\PluginInterface;

/**
 * Class PhanRunner
 * @package Phalyfusion\Plugins\Phan
 */
class PhanRunner implements PluginInterface
{
    private const name = "phan";

    /**
     * @var string
     */
    private string $run_command;

    /**
     * PhanRunner constructor.
     * @param string $run_command
     */
    public function __construct($run_command)
    {
        echo("Hello, Phan!\n");
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