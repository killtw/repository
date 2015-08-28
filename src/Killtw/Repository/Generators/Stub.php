<?php

namespace Killtw\Repository\Generators;

/**
 * Class Stub
 *
 * @package Killtw\Repository\Generators
 */
class Stub
{
    /**
     * @var string
     */
    protected $filepath;
    /**
     * @var null
     */
    protected $replacements;

    /**
     * Stub constructor.
     *
     * @param string $filepath
     * @param array $replacements
     */
    public function __construct($filepath, $replacements = [])
    {
        $this->filepath = $filepath;
        $this->replacements = $replacements;

        return $this->getContent();
    }

    /**
     * @return mixed|string
     */
    public function getContent()
    {
        $content = file_get_contents($this->getPath());
        foreach ($this->replacements as $search => $replace) {
            $content = str_replace('$' . strtoupper($search) . '$', $replace, $content);
        }

        return $content;
    }

    /**
     * @return string
     */
    private function getPath()
    {
        return $this->filepath;
    }

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->getContent();
    }
}
