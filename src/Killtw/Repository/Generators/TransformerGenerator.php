<?php

namespace Killtw\Repository\Generators;

/**
 * Class TransformerGenerator
 *
 * @package Killtw\Repository\Generators
 */
class TransformerGenerator extends Generator
{
    /**
     * Stub for generator.
     *
     * @var string
     */
    protected $stub = 'transformer';

    /**
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'model' => (strpos('\\', $this->getOption('model')) != false) ? $this->getOption('model') : $this->getModelNamespace() . $this->getOption('model')
        ]);
    }

    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . 'Repositories\\Transformers\\';
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/Repositories/Transformers/' . $this->getName() . 'Transformer.php';
    }
}
