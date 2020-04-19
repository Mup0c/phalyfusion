<?php


namespace Phalyfusion;


use Composer\Autoload\ClassMapGenerator;
use Phalyfusion\Plugins\PluginRunnerInterface;


/**
 * Class Core
 */
class Core  #Инициализация (установка) плагинов (их конфигов) происходит средствами самих плагинов (обычно руками). php-ast руками??
{

    /**
     * @var PluginRunnerInterface[]
     */
    private array $plugins;

    /**
     * List of names of plugins to run
     * @var string[]
     */
    private array $usedPlugins;

    /**
     * Run command for each plugin
     * @var string[]
     */
    private array $runCommands;

    /**
     * Path to the root directory of the tool
     * @var string
     */
    private string $rootDir;

    /**
     * Core constructor.
     * @param string $rootDir Path to the root directory of the tool
     * @param array $usedPlugins List of names of plugins to run
     * @param array $runCommands Run command for each plugin
     */
    public function __construct(string $rootDir, array $usedPlugins, array $runCommands)
    {
        $this->plugins = array();
        $this->rootDir = $rootDir;
        $this->usedPlugins = $usedPlugins;
        $this->runCommands = $runCommands;
        $this->loadPlugins();
    }

    /**
     * Create instances of plugins classes stated in config
     */
    private function loadPlugins()
    {

        $class_map = ClassMapGenerator::createMap($this->rootDir . '/src/Plugins');
        foreach ($class_map as $class => $path)
        {
            if (in_array("Phalyfusion\Plugins\PluginRunnerInterface", class_implements($class))
                && in_array($class::getName(), $this->usedPlugins))
            {
                $this->plugins[] = new $class();
            }
        }

    }

    /**
     * Run static code analysers #TODO: Return PluginOutput[]
     */
    public function runPlugins()
    {
        foreach ($this->plugins as $plugin)
        {
            $plugin->run($this->runCommands[$plugin::getName()]);
        }
    }

}
