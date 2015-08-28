<?php

namespace Killtw\Repository\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface RepositoryCriteriaInterface
 *
 * @package Killtw\Repository\Contracts
 */
interface RepositoryCriteriaInterface
{
    /**
     * @param bool|false $status
     *
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * @return Collection
     */
    public function getCriteria();

    /**
     * @param CriteriaInterface|string $criteria
     *
     * @return Collection
     */
    public function getByCriteria($criteria);

    /**
     * @param CriteriaInterface|string $criteria
     *
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * @return $this
     */
    public function applyCriteria();
}
