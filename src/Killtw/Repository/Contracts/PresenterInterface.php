<?php

namespace Killtw\Repository\Contracts;

/**
 * Interface PresenterInterface
 *
 * @package Killtw\Repository\Contracts
 */
interface PresenterInterface
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function present($data);
}
