<?php


namespace Phalyfusion\Model;


use JsonSerializable;

/**
 * Class PluginOutputModel
 * Model presenting output of the plugin as FileModel for file path
 * @package Phalyfusion\Model
 */
class PluginOutputModel implements JsonSerializable
{

    /**
     * $files = ['<fileName>' => FileModel]
     * @var FileModel[]
     */
    private array $files = array();

    /**
     * $files = ['<fileName>' => FileModel]
     * @return FileModel[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * $files = ['<fileName>' => FileModel]
     * @param FileModel[] $files
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }

    /**
     * @param string $filePath
     * @param ErrorModel $errorModel
     */
    public function appendError(string $filePath, ErrorModel $errorModel): void
    {
        $this->appendFileIfNotExists($filePath);
        $this->files[$filePath]->appendError($errorModel);
    }

    /**
     * @param string $filePath
     */
    public function appendFileIfNotExists(string $filePath): void
    {
        if (!array_key_exists($filePath, $this->files))
        {
            $this->files[$filePath] = new FileModel($filePath);
        }
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}