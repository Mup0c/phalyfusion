<?php

namespace Phalyfusion;


use Composer\Autoload\ClassMapGenerator;
use Phalyfusion\Model\PluginOutputModel;
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
    private function loadPlugins(): void
    {
        $classMap = ClassMapGenerator::createMap($this->rootDir . '/src/Plugins');
        foreach ($classMap as $class => $path)
        {
            $interface = PluginRunnerInterface::class;
            try {
                $reflection = new \ReflectionClass($class);
            } catch (\ReflectionException $e) {
                echo $e;
                exit(1);      //TODO: nice error output
            }

            if ($reflection->implementsInterface($interface)
                && $reflection->isInstantiable()
                #&& in_array(call_user_func($class.'::getName'), $this->usedPlugins)) // php call object method. //No. https://www.php.net/manual/en/language.oop5.static.php
                && method_exists($class, 'getName') //suppress phpstorm inspection warning next line
                && in_array($class::getName(), $this->usedPlugins))
            {
                $this->plugins[] = new $class();
            }
        }
    }

    /**
     * Run static code analysers
     * @return PluginOutputModel[]
     */
    public function runPlugins(): array
    {
        $output = array();
        foreach ($this->plugins as $plugin)
        {
            $output[] = $plugin->run($this->runCommands[$plugin::getName()]); #TODO: undefined index error (no run command for such plugin in config)
        }
        return $output;
    }

}
