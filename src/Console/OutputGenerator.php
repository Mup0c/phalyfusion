<?php


namespace Phalyfusion\Console;


use Phalyfusion\Model\PluginOutputModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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

        return $resultModel;
    }

    /**
     * @param PluginOutputModel[] $outputModels
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public static function consoleStyle(array $outputModels, InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $model = self::combineModels($outputModels);
        $errorCount = 0;

        $io->title(' ~~ Phalyfusion! ~~ ');
        if (!$model->getFiles())
        {
            $io->success('No errors found!');
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
            $io->table(['Line', 'Plugin', $fileModel->getPath()], $rows);
        }

        $io->error("$errorCount errors found!");

        return 1;
    }

}