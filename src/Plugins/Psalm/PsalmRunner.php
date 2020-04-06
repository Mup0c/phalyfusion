<?php


namespace Phalyfusion\Plugins\Psalm;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Phalyfusion\Plugins\PluginRunnerInterface;

/**
 * Class PsalmRunner
 * @package Phalyfusion\Plugins\Psalm
 */
class PsalmRunner implements PluginRunnerInterface
{
    private const name = "psalm";

    /**
     * @var string
     */
    private string $run_command;

    /**
     * PsalmRunner constructor.
     * @param string $run_command
     */
    public function __construct($run_command)
    {
        echo("Hello, Psalm!\n");
        $this->run_command = $run_command;
    }

    /**
     * @inheritDoc
     */
    public static function getName()
    {
        return self::name;
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        // TODO: Implement run() method. #Все-таки запускать здесь, или просто генерировать путь\ключи и запустить в ядре. Или вообще зафигачить трейт.
        $process = new Process(['bin/psalm'],'../' );
        $process->run();
        echo("\n---PSALM--- \n");
        echo $process->getErrorOutput();
        echo $process->getOutput();
    }
}