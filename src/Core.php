<?php
require_once '../Vendor/autoload.php';

use Composer\Autoload\ClassMapGenerator;
use Plugins\PluginInterface;

class Core
{

    /**
     * @var PluginInterface[]
     */
    public $plugins; #private

    public function __construct()
    {
        $this->plugins = array();
        echo("Hello, Core!\n");
    }

    public function load_plugins() #private
    {
        $class_map = ClassMapGenerator::createMap(__DIR__.'/Plugins', "/.*Interface.php/");
        foreach ($class_map as $class => $path)
        {
            if (in_array("Plugins\PluginInterface", class_implements($class)))
            {
                $this->plugins[] = new $class;
            }
        }

    }

}

$kek = new Core();
$kek->load_plugins();

var_dump($kek->plugins);
