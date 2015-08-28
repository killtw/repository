<?php

namespace Killtw\Repository\Criteria;

use Illuminate\Http\Request;
use Killtw\Repository\Contracts\CriteriaInterface;
use Killtw\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderByCriteria
 *
 * @package Killtw\Repository\Criteria
 */
class OrderByCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * orderByCriteria constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $orderBy = $this->request->get(
            config('repository.criteria.params.orderBy'),
            ($repository->orderBy) ?: 'id'
        );
        $sortBy = $this->request->get(
            config('repository.criteria.params.sortBy'),
            ($repository->sortBy) ?: 'asc'
        ) ?: 'asc';
        if (isset($orderBy)) {
            $model = $model->orderBy($orderBy, $sortBy);
        }

        return $model;
    }
}
