<?php
require_once '../Vendor/autoload.php';

use Plugins\Phan\PhanRunner;
use Composer\Autoload\ClassMapGenerator;
class Core
{
    public function __construct()
    {
        echo("Hello\n");
    }

}
