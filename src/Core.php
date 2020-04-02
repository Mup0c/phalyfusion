<?php


namespace Phalyfusion;

require_once __DIR__.'/../vendor/autoload.php'; #Как делать это ТРУЪ

use Composer\Autoload\ClassMapGenerator;
use Phalyfusion\Plugins\PluginInterface;
use Nette\Neon\Neon;
use Nette\Neon\Exception as NeonException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class Core
 */
class Core  #Инициализация плагинов (их конфигов) происходит средствами самих плагинов (обычно руками). php-ast руками??
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
        } catch (NeonException $e) {

        }
    }

    /**
     * Create instances of plugin classes stated in config
     */
    private function load_plugins()
    {
        $used_plugins = $this->config["plugins"]["usePlugins"];

        $class_map = ClassMapGenerator::createMap(__DIR__.'/Plugins');
        foreach ($class_map as $class => $path)
        {
            if (in_array("Phalyfusion\Plugins\PluginInterface", class_implements($class))
                && in_array($class::get_name(), $used_plugins))
            {
                $run_command = $this->config["plugins"][$class::get_name()];
                $this->plugins[] = new $class($run_command);
            }
        }

    }

}

$kek = new Core();
var_dump($kek->plugins);


#$process = new Process(['bin/phan'],'../' );
$process2 = new Process(['bin/phpstan', 'analyse'],'../' );
#$process2 = new Process(['bin/psalm'],'../' );


#$process->run();
$process2->run();

// executes after the command finishes
#if (!$process->isSuccessful()) {
#    throw new ProcessFailedException($process);
#}

#echo $process->getErrorOutput();
#echo $process->getOutput();
echo $process2->getOutput();

#$process->clearOutput();
#$process->clearErrorOutput();
#echo $process->getOutput();