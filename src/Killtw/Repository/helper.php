<?php

use Illuminate\Container\Container;

if ( ! function_exists('repo')) {
    /**
     * @param null $make
     * @param array $parameters
     *
     * @return mixed|static
     */
    function repo($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        $repoPath = config('repository.generator.rootNamespace') . 'Repositories\\';

        return Container::getInstance()->make($repoPath . $make, $parameters);
    }

}
