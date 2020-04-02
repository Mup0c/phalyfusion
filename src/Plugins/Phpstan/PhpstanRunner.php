<?php


namespace Plugins\Phpstan;

use Plugins\PluginInterface;

/**
 * Class PhpstanRunner
 * @package Plugins\Phpstan
 */
class PhpstanRunner implements PluginInterface
{
    private const name = "phpstan";

    /**
     * @var string
     */
    private string $run_command;

    /**
     * PhpstanRunner constructor.
     * @param string $run_command
     */
    public function __construct($run_command)
    {
        echo("Hello, Phpstan!\n");
        $this->run_command = $run_command;
    }

    /**
     * @inheritDoc
     */
    public static function get_name()
    {
        return self::name;
    }
}