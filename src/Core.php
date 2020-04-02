<?php
require_once '../Vendor/autoload.php';

use Composer\Autoload\ClassMapGenerator;
use Plugins\PluginInterface;
use Nette\Neon\Neon;


/**
 * Class Core
 */
class Core
{

    private const config_path = "../config.neon"; #TODO: From CLI

    /**
     * @var PluginInterface[]
     */
    public array $plugins; #private

    /**
     * @var array
     */
    public array $config; #private

    /**
     * Core constructor.
     */
    public function __construct()
    {
        $this->plugins = array();
        $this->read_config();
        $this->load_plugins();
        echo("Hello, Core!\n");
    }

    /**
     * Parse config
     */
    private function read_config() #TODO: Exception handling??
    {
        $neon = file_get_contents(self::config_path);
        try {
            $this->config = Neon::decode($neon);
        } catch (Nette\Neon\Exception $e) {

        }
    }

    /**
     * Create instances of plugins classes, stated in config
     */
    private function load_plugins()
    {
        $anls = $this->config["plugins"]["usePlugins"];

        $class_map = ClassMapGenerator::createMap(__DIR__.'/Plugins');
        foreach ($class_map as $class => $path)
        {
            if (in_array("Plugins\PluginInterface", class_implements($class)) && in_array($class::get_name(), $anls))
            {
                $run_command = $this->config["plugins"][$class::get_name()];
                $this->plugins[] = new $class($run_command);
            }
        }

    }

}

$kek = new Core();
var_dump($kek->plugins);
