<?php


namespace Phalyfusion\Console;


use Phalyfusion\Model\FileModel;
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
            foreach ($model->files as $filePath => $fileModel)
            {
                if (!array_key_exists($filePath, $resultModel->files))
                {
                    $resultModel->files[$filePath] = new FileModel($filePath);
                }
                $resultModel->files[$filePath]->errors = array_merge($resultModel->files[$filePath]->errors,
                                                                     $fileModel->errors);
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

        if (!$model->files)
        {
            $io->success('No errors found!');
            return 0;
        }

        foreach ($model->files as $fileModel)
        {
            $rows = array();
            foreach ($fileModel->errors as $errorModel)
            {
                $rows[] = [$errorModel->line, $errorModel->pluginName, $errorModel->message];
                $errorCount++;
            }
            $io->table(['Line', 'Plugin', $fileModel->path], $rows);
        }

        $io->error("$errorCount errors found!");

        return 1;
    }

}