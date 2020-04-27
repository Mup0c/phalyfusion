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
    public string $path;

    /**
     * @var ErrorModel[]
     */
    public array $errors = array();

    /**
     * FileModel constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

}