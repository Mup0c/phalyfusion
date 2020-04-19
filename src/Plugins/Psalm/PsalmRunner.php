<?php


namespace Phalyfusion\Plugins\Psalm;

use Phalyfusion\Plugins\PluginRunner;
use Phalyfusion\Plugins\PluginRunnerInterface;

/**
 * Class PsalmRunner
 * @package Phalyfusion\Plugins\Psalm
 */
class PsalmRunner extends PluginRunner implements PluginRunnerInterface
{
    private const name = "psalm";

    /**
     * PsalmRunner constructor.
     */
    public function __construct()
    {
        echo("Hello, Psalm!\n");
    }

    /**
     * @inheritDoc
     */
    public static function getName()
    {
        return self::name;
    }

}