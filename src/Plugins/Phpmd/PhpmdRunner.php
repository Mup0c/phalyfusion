<?php


namespace Phalyfusion\Plugins\Phpmd;


use Phalyfusion\Console\IOHandler;
use Phalyfusion\Model\ErrorModel;
use Phalyfusion\Model\PluginOutputModel;
use Phalyfusion\Plugins\PluginRunner;

/**
 * Class PhpmdRunner
 * @package Phalyfusion\Plugins\Phpmd
 */
class PhpmdRunner extends PluginRunner
{

    private const name = "phpmd";

    /**
     * PhpmdRunner constructor.
     */
    public function __construct()
    {
        IOHandler::debug('Hello, PHPMD!');
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
        preg_match_all('/\'.*?\'|".*?"|\S+/', $runCommand, $matches);
        $matches[0][2] = 'json';
        $runCommand = implode(' ', $matches[0]);
        return $runCommand;
    }

    /**
     * @inheritDoc
     */
    protected function parseOutput(string $output): PluginOutputModel
    {
        $outputModel = new PluginOutputModel();

        $decoded = json_decode($output, true);
        foreach ($decoded['files'] as $file)
        {
            foreach ($file['violations'] as $error)
            {
                $errorModel = new ErrorModel($error['beginLine'], $error['description'], 'error', self::name);
                $outputModel->appendError($file['file'], $errorModel);
            }
        }

        return $outputModel;
    }
}