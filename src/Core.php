<?php

namespace Phalyfusion;


use Composer\Autoload\ClassMapGenerator;
use Phalyfusion\Console\IOHandler;
use Phalyfusion\Model\PluginOutputModel;
use Phalyfusion\Plugins\PluginRunnerInterface;


/**
 * Class Core
 */
class Core
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
     * Paths with source code to run analysis on
     * @var string[]
     */
    private array $paths;

    /**
     * Core constructor.
     * @param string $rootDir Path to the root directory of the tool
     * @param string[] $usedPlugins List of names of plugins to run
     * @param string[] $runCommands Run command for each plugin
     * @param string[] $paths Paths with source code to run analysis on
     */
    public function __construct(string $rootDir, array $usedPlugins, array $runCommands, array $paths)
    {
        $this->plugins = array();
        $this->rootDir = $rootDir;
        $this->usedPlugins = $usedPlugins;
        $this->runCommands = $runCommands;
        $this->paths = $paths;
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
                IOHandler::error('Failed creating ReflectionClass', $e);
                exit(1);
            }

            if ($reflection->implementsInterface($interface)
                && $reflection->isInstantiable()
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
            $pluginName = $plugin::getName();
            if (!array_key_exists($pluginName, $this->runCommands))
            {
                IOHandler::error("$pluginName run failed!", "No run command for $pluginName provided in config");
                continue;
            }
            $output[] = $plugin->run($this->runCommands[$pluginName], $this->paths);
        }
        return $output;
    }

}
