<?php


namespace Phalyfusion\Plugins\Phpstan;

use Phalyfusion\Console\IOHandler;
use Phalyfusion\Model\ErrorModel;
use Phalyfusion\Model\PluginOutputModel;
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
        IOHandler::debug('Hello, Phpstan!');
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
        $runCommand = $this->addOption($runCommand, '--error-format=json');
        return $runCommand;
    }

    /**
     * @inheritDoc
     */
    protected function parseOutput(string $output): PluginOutputModel
    {
        $outputModel = new PluginOutputModel();

        $decoded = json_decode($output, true);
        foreach ($decoded['files'] as $filePath => $errors)
        {
            foreach ($errors['messages'] as $error)
            {
                $errorModel = new ErrorModel($error['line'], $error['message'], 'error', self::name);
                $outputModel->appendError($filePath, $errorModel);
            }
        }

        return $outputModel;
    }

}