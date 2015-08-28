<?php

namespace Killtw\Repository\Generators;

/**
 * Class PresenterGenerator
 *
 * @package Killtw\Repository\Generators
 */
class PresenterGenerator extends Generator
{
    /**
     * @var string
     */
    protected $stub = 'presenter';

    /**
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'transformer' => $this->getOption('transformer') ?: parent::getRootNamespace() . 'Repositories\\Transformers\\' . $this->getName()
        ]);
    }

    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . 'Repositories\\Presenters\\';
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/Repositories/Presenters/' . $this->getName() . 'Presenter.php';
    }
}
