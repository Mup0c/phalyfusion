<?php


namespace Phalyfusion\Plugins\Phpstan;

use Phalyfusion\Plugins\PluginRunner;
use Phalyfusion\Plugins\PluginRunnerInterface;

/**
 * Class PhpstanRunner
 * @package Phalyfusion\Plugins\Phpstan
 */
class PhpstanRunner extends PluginRunner implements PluginRunnerInterface
{
    private const name = "phpstan";

    /**
     * PhpstanRunner constructor.
     */
    public function __construct()
    {
        echo("Hello, Phpstan!\n");
    }

    /**
     * @inheritDoc
     */
    public static function getName()
    {
        return self::name;
    }

}