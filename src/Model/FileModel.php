<?php


namespace Phalyfusion\Model;


/**
 * Class FileModel
 * Presenting error list for a file as an ErrorModel array.
 * @package Phalyfusion\Model
 */
class FileModel
{

    /**
     * @var string
     */
    private string $path;

    /**
     * @var ErrorModel[]
     */
    private array $errors = array();

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return ErrorModel[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param ErrorModel[] $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @param ErrorModel $errorModel
     */
    public function appendError(ErrorModel $errorModel): void
    {
        $this->errors[] = $errorModel;
    }

    /**
     * FileModel constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

}