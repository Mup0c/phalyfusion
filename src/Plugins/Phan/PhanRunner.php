<?php

namespace Plugins\Phan;

use Plugins\PluginInterface;

class PhanRunner implements PluginInterface
{
    public function __construct()
    {
        echo("Hello, Phan!\n");
    }
}