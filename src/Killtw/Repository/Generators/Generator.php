<?php

namespace Killtw\Repository\Generators;

use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Killtw\Repository\Exceptions\FileExistsException;

/**
 * Class Generator
 *
 * @package Killtw\Repository\Generators
 */
abstract class Generator
{
    use AppNamespaceDetectorTrait;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var array
     */
    protected $options;

    /**
     * Stub for generator.
     *
     * @var string
     */
    protected $stub;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->filesystem = new Filesystem;
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return config('repository.generator.basePath', app_path());
    }

    /**
     * @return mixed
     */
    public function getRootNamespace()
    {
        return config('repository.generator.rootNamespace', $this->getAppNamespace());
    }

    /**
     * @return mixed
     */
    public function getModelNamespace()
    {
        return config('repository.generator.modelNamespace', $this->getAppNamespace());
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        $segments = $this->getSegments();
        array_pop($segments);
        $rootNamespace = $this->getRootNamespace();
        if ($rootNamespace == false) {
            return null;
        }

        return rtrim($rootNamespace . implode($segments, '\\'), '\\');
    }

    /**
     * @return array
     */
    public function getReplacements()
    {
        return [
            'class' => $this->getClass(),
            'namespace' => $this->getNamespace(),
            'root_namespace' => $this->getRootNamespace()
        ];
    }

    /**
     * @return int
     * @throws FileExistsException
     */
    public function run()
    {
        if ($this->filesystem->exists($path = $this->getPath())) {
            throw new FileExistsException($path);
        }
        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }

        return $this->filesystem->put($path, $this->getStub());
    }

    /**
     * @return string
     */
    protected function getName()
    {
        $name = $this->name;
        if (str_contains('\\', $this->name)) {
            $name = str_replace('\\', '/', $this->name);
        }

        return Str::studly(ucwords($name));
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . $this->getName() . '.php';
    }

    /**
     * @return string
     */
    private function getClass()
    {
        return Str::studly(class_basename($this->getName()));
    }

    /**
     * @return array
     */
    private function getSegments()
    {
        return explode('/', $this->getName());
    }

    /**
     * @return Stub
     */
    private function getStub()
    {
        return new Stub(
            __DIR__ . '/stubs/' . $this->stub . '.stub',
            $this->getReplacements()
        );
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function getOption($key)
    {
        if (!$this->hasOption($key)) {
            return null;
        }

        return $this->options[$key] ?: null;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    private function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $this->getOption($key);
    }
}
