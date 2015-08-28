<?php

namespace Killtw\Repository\Contracts;

/**
 * Interface RepositoryPresenterInterface
 *
 * @package Killtw\Repository\Contracts
 */
interface RepositoryPresenterInterface
{
    /**
     * @param PresenterInterface $presenter
     *
     * @return mixed
     */
    public function setPresenter(PresenterInterface $presenter);

    /**
     * @param bool|true $status
     *
     * @return mixed
     */
    public function skipPresenter($status = true);
}
