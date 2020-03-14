<?php


namespace Plugins\Phpstan;

use Plugins\PluginInterface;

class PhpstanRunner implements PluginInterface
{
    public function __construct()
    {
        echo("Hello, Phpstan!\n");
    }
}