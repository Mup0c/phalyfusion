<?php


namespace Phalyfusion\Plugins\Phan;

use Phalyfusion\Plugins\PluginRunner;
use Phalyfusion\Plugins\PluginRunnerInterface;

/**
 * Class PhanRunner
 * @package Phalyfusion\Plugins\Phan
 */
class PhanRunner extends PluginRunner implements PluginRunnerInterface
{
    private const name = "phan";

    /**
     * PhanRunner constructor.
     */
    public function __construct()
    {
        echo("Hello, Phan!\n");
    }

    /**
     * @inheritDoc
     */
    public static function getName()
    {
        return self::name;
    }

}