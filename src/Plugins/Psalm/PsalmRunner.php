<?php


namespace Phalyfusion\Plugins\Psalm;

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
        $runCommand = preg_replace('/\s--output-format=(\'.*?\'|".*?"|\S+)/', '', $runCommand);
        $runCommand = $this->addOption($runCommand, '--output-format=json');
        return $runCommand;
    }

    /**
     * @inheritDoc
     */
    protected function parseOutput(string $output): PluginOutputModel
    {
        $outputModel = new PluginOutputModel();

        $decoded = json_decode($output, true);
        foreach ($decoded as $error)
        {
            $filePath = $error['file_path'];
            $errorModel = new ErrorModel($error['line_from'], $error['message'], $error['severity'], self::name);
            $outputModel->appendError($filePath, $errorModel);
        }

        return $outputModel;
    }

}
