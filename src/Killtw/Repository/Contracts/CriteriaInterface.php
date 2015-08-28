<?php

namespace Killtw\Repository\Contracts;

/**
 * Interface CriteriaInterface
 *
 * @package Killtw\Repository\Contracts
 */
interface CriteriaInterface
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
