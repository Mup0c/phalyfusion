<?php


namespace Phalyfusion;

require_once __DIR__.'/../vendor/autoload.php'; #Как делать это ТРУЪ

use Composer\Autoload\ClassMapGenerator;
use Phalyfusion\Plugins\PluginRunnerInterface;
use Nette\Neon\Neon;
use Nette\Neon\Exception as NeonException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class Core
 */
class Core  #Инициализация (установка) плагинов (их конфигов) происходит средствами самих плагинов (обычно руками). php-ast руками??
{

    private const config_path = "../config.neon"; #TODO: From CLI

    /**
     * @var PluginRunnerInterface[]
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
        echo("Hello, Core!\n");
        $this->plugins = array();
        $this->readConfig();
        $this->loadPlugins();
        $this->runPlugins();
    }

    /**
     * Parse config
     */
    private function readConfig() #TODO: Exception handling??
    {
        $neon = file_get_contents(self::config_path);
        try {
            $this->config = Neon::decode($neon);
        } catch (NeonException $e) {
            echo("Failed parsing config");
        }
    }

    /**
     * Create instances of plugin classes stated in config
     */
    private function loadPlugins()
    {
        $used_plugins = $this->config["plugins"]["usePlugins"];

        $class_map = ClassMapGenerator::createMap(__DIR__.'/Plugins');
        foreach ($class_map as $class => $path)
        {
            if (in_array("Phalyfusion\Plugins\PluginRunnerInterface", class_implements($class))
                && in_array($class::getName(), $used_plugins))
            {
                $run_command = $this->config["plugins"][$class::getName()];
                $this->plugins[] = new $class($run_command);
            }
        }

    }

    /**
     * Run static code analysers
     */
    private function runPlugins()
    {
        foreach ($this->plugins as $plugin)
        {
            $plugin->run();
        }
    }

}

$kek = new Core();
var_dump($kek->plugins);


#$process = new Process(['bin/phan'],'../' );
#$process2 = new Process(['bin/phpstan', 'analyse'],'../' );
#$process2 = new Process(['bin/psalm'],'../' );


#$process->run();
#$process2->run();

// executes after the command finishes
#if (!$process->isSuccessful()) {
#    throw new ProcessFailedException($process);
#}

#echo $process->getErrorOutput();
#echo $process->getOutput();
#echo $process2->getOutput();

#$process->clearOutput();
#$process->clearErrorOutput();
#echo $process->getOutput();