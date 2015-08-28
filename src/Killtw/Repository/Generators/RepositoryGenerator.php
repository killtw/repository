<?php

namespace Killtw\Repository\Generators;

/**
 * Class RepositoryGenerator
 *
 * @package Killtw\Repository\Generators
 */
class RepositoryGenerator extends Generator
{
    /**
     * Stub for generator.
     *
     * @var string
     */
    protected $stub = 'repository';

    /**
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'model' => (strpos('\\', $this->getOption('model')) != false) ? $this->getOption('model') : $this->getModelNamespace() . $this->getOption('model'),
            'presenter' => $this->getOption('presenter'),
            'presenterClass' => $this->getOption('presenterClass') ?: 'null',
        ]);
    }

    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . 'Repositories\\';
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/Repositories/' . $this->getName() . 'Repository.php';
    }
}
