<?php


namespace Phalyfusion\Plugins\Psalm;

use Phalyfusion\Console\IOHandler;
use Phalyfusion\Model\ErrorModel;
use Phalyfusion\Model\PluginOutputModel;
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
        IOHandler::debug('Hello, Psalm!');
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
    protected function prepareCommand(string $runCommand, array $paths): string
    {
        $runCommand = preg_replace('/\s--output-format=(\'.*?\'|".*?"|\S+)/', '', $runCommand);
        $runCommand = $this->addOption($runCommand, '--output-format=json');
        foreach ($paths as &$path) {
            $path = "'$path'" ;
        }
        $runCommand .= ' ' . implode(' ', $paths);
        return $runCommand;
    }

    /**
     * @inheritDoc
     */
    protected function parseOutput(string $output): PluginOutputModel
    {
        $outputModel = new PluginOutputModel();

        $decoded = json_decode($output, true);
        if ($decoded)
        {
            foreach ($decoded as $error)
            {
                $filePath = $error['file_path'];
                $errorModel = new ErrorModel($error['line_from'], $error['message'], $error['severity'], self::name);
                $outputModel->appendError($filePath, $errorModel);
            }
        }

        return $outputModel;
    }

}
