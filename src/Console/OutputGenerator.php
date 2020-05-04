<?php


namespace Phalyfusion\Console;


use Phalyfusion\Model\ErrorModel;
use Phalyfusion\Model\PluginOutputModel;


/**
 * Class OutputGenerator
 * @package Phalyfusion\Model
 */
class OutputGenerator
{

    /**
     * @param PluginOutputModel[] $outputModels
     * @return PluginOutputModel
     */
    private static function combineModels(array $outputModels): PluginOutputModel
    {
        $resultModel = new PluginOutputModel();
        foreach ($outputModels as $model)
        {
            foreach ($model->getFiles() as $filePath => $fileModel)
            {
                $resultModel->appendFileIfNotExists($filePath);
                $resultFiles = $resultModel->getFiles();
                $resultFiles[$filePath]->setErrors(array_merge($resultFiles[$filePath]->getErrors(),
                                                               $fileModel->getErrors()));
                $resultModel->setFiles($resultFiles);
            }
        }

        $resultFiles = $resultModel->getFiles();
        foreach ($resultFiles as $fileModel)
        {
            $errors = $fileModel->getErrors();
            usort($errors, fn(ErrorModel $a, ErrorModel $b) => $a->getLine() - $b->getLine());
            $fileModel->setErrors($errors);
        }
        $resultModel->setFiles($resultFiles);

        return $resultModel;
    }

    /**
     * @param PluginOutputModel[] $outputModels
     * @return int
     */
    public static function consoleOutput(array $outputModels): int
    {
        $model = self::combineModels($outputModels);
        $errorCount = 0;

        IOHandler::$io->title(' ~~ Phalyfusion! ~~ ');
        if (!$model->getFiles())
        {
            IOHandler::$io->success('No errors found!');
            return 0;
        }

        foreach ($model->getFiles() as $fileModel)
        {
            $rows = array();
            foreach ($fileModel->getErrors() as $errorModel)
            {
                $rows[] = [$errorModel->getLine(), $errorModel->getPluginName(), $errorModel->getMessage()];
                $errorCount++;
            }
            IOHandler::$io->table(['Line', 'Plugin', $fileModel->getPath()], $rows);
        }

        IOHandler::$io->error("$errorCount errors found!");

        return 1;
    }

}