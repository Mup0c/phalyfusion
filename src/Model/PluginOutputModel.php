<?php


namespace Phalyfusion\Model;


/**
 * Class PluginOutputModel
 * Model presenting output of the plugin as FileModel for file path
 * @package Phalyfusion\Model
 */
class PluginOutputModel
{

    /**
     * $files = ['<fileName>' => FileModel]
     * @var FileModel[]
     */
    public array $files = array();

}