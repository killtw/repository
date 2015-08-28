<?php

namespace Killtw\Repository\Exceptions;

use Exception;

/**
 * Class FileExistsException
 *
 * @package Killtw\Repository\Exceptions
 */
class FileExistsException extends Exception
{
    /**
     * @var string
     */
    protected $path;

    /**
     * FileExistsException constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        parent::__construct('File already exists at path: '.$this->getPath());
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
