<?php


namespace Phalyfusion\Plugins\Phan;

use Phalyfusion\Console\IOHandler;
use Phalyfusion\Model\ErrorModel;
use Phalyfusion\Model\PluginOutputModel;
use Phalyfusion\Plugins\PluginRunner;

/**
 * Class PhanRunner
 * @package Phalyfusion\Plugins\Phan
 */
class PhanRunner extends PluginRunner
{

    private const name = "phan";

    /**
     * PhanRunner constructor.
     */
    public function __construct()
    {
        IOHandler::debug('Hello, Phan!');
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
        $runCommand =  preg_replace('/(\s--output-mode(=|\s+?)|\s-m(=|\s*))(\'.*?\'|".*?"|\S+)/', '', $runCommand);
        $runCommand = $this->addOption($runCommand, '--output-mode=json');
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
            $filePath = getcwd().'/'.$error['location']['path'];
            $errorModel = new ErrorModel($error['location']['lines']['begin'], $error['description'],
                                         $error['type'], self::name);
            $outputModel->appendError($filePath, $errorModel);
        }

        return $outputModel;
    }

}