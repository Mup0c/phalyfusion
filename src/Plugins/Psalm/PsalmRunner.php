<?php


namespace Phalyfusion\Plugins\Psalm;

use Phalyfusion\Plugins\PluginRunner;

/**
 * Class PsalmRunner
 * @package Phalyfusion\Plugins\Psalm
 */
class PsalmRunner extends PluginRunner
{
    private const name = "psalm";

    /**
     * PsalmRunner constructor.
     */
    public function __construct()
    {
        echo("Hello, Psalm!\n");
    }

    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return self::name;
    }

    /**
     * @inheritDoc
     */
    protected function prepareCommand(string $runCommand): string
    {
        #$option = '--output-format=checkstyle';
        #$runCommand = preg_replace('/--output-format=(\'.*?\'|".*?"|\S+)/', $option, $runCommand, -1, $count);
        $runCommand = preg_replace('/\s--output-format=(\'.*?\'|".*?"|\S+)/', '', $runCommand);
        $runCommand = $this->addOption($runCommand, '--output-format=checkstyle');
        return $runCommand;
    }
}
