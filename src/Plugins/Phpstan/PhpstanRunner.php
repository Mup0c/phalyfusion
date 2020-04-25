<?php


namespace Phalyfusion\Plugins\Phpstan;

use Phalyfusion\Plugins\PluginRunner;

/**
 * Class PhpstanRunner
 * @package Phalyfusion\Plugins\Phpstan
 */
class PhpstanRunner extends PluginRunner
{
    private const name = "phpstan";

    /**
     * PhpstanRunner constructor.
     */
    public function __construct()
    {
        echo("Hello, Phpstan!\n");
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
        $runCommand =  preg_replace('/\s--error-format(=|\s+?)(\'.*?\'|".*?"|\S+)/', '', $runCommand);
        $runCommand = $this->addOption($runCommand, '--error-format=checkstyle');
        return $runCommand;
    }
}