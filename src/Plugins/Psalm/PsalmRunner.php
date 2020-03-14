<?php


namespace Plugins\Psalm;

use Plugins\PluginInterface;

class PsalmRunner implements PluginInterface
{
    public function __construct()
    {
        echo("Hello, Psalm!\n");
    }
}