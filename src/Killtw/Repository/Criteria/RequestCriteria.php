<?php

namespace Killtw\Repository\Criteria;

use Illuminate\Http\Request;
use Killtw\Repository\Contracts\CriteriaInterface;
use Killtw\Repository\Contracts\RepositoryInterface;

/**
 * Class RequestCriteria
 *
 * @package Killtw\Repository\Criteria
 */
class RequestCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * RequestCriteria constructor.
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
        if ($this->request->method() !== 'GET') {
            return $model;
        }
        $searchableFields = $repository->getSearchableFields();
        $queryString = $this->request->except([
            config('repository.criteria.params.filter'),
            config('repository.criteria.params.orderBy'),
            config('repository.criteria.params.sortBy'),
            'page'
        ]);
        $filter = $this->request->get(config('repository.criteria.params.filter'), null);
        $searchData = $this->parseSearchData($queryString, $searchableFields);
        if ($searchData && !empty($searchData)) {
            $model = $this->setModelQuery($model, $searchData);
        }
        if ($filter) {
            if (is_string($filter)) {
                $filter = explode(';', $filter);
            }
            $model = $model->select($filter);
        }

        return $model;
    }

    /**
     * @param $queryString
     * @param $searchableFields
     *
     * @return array
     */
    private function parseSearchData($queryString, $searchableFields)
    {
        $searchData = [];
        foreach ($searchableFields as $column => $condition) {
            if (is_numeric($column)) {
                $searchableFields[$condition] = '=';
            } else {
                $searchableFields[$column] = $condition;
            }
        }
        foreach ($queryString as $field => $value) {
            $value = explode(':', $value);
            if (count($value) == 2) {
                if (array_key_exists($field, $searchableFields)) {
                    $searchData[$field] = $this->parseCondition($value[0], $value[1]);
                }
            } else {
                if (array_key_exists($field, $searchableFields)) {
                    $searchData[$field] = $this->parseCondition($value[0], $searchableFields[$field]);
                }
            }

        }

        return $searchData;
    }

    /**
     * @param $searchValue
     * @param $condition
     *
     * @return array
     */
    private function parseCondition($searchValue, $condition)
    {
        $acceptedConditions = config('repository.criteria.acceptedConditions', ['=', 'like']);
        switch (trim(strtolower($condition))) {
            case 'above':
            case 'plus':
            case 'more':
            case '>':
                $condition = '>';
                break;
            case 'below':
            case 'minus':
            case 'less':
            case '<':
                $condition = '<';
                break;
            case 'equal':
            case 'is':
            case '=':
                $condition = '=';
                break;
            case 'like':
                $condition = 'like';
                break;
        }
        if (!in_array($condition, $acceptedConditions)) {
            $condition = '=';
        }

        return [
            'value' => ($condition == 'like') ? "%$searchValue%" : $searchValue,
            'condition' => $condition
        ];
    }

    /**
     * @param $model
     * @param $searchData
     *
     * @return mixed
     */
    private function setModelQuery($model, $searchData)
    {
        foreach ($searchData as $field => $searchValue) {
            $field = explode('-', $field);
            if (count($field) == 2) {
                $model = $model->whereHas($field[0], function($query) use($field, $searchValue) {
                    if (is_array($searchValue['value'])) {
                        $query->whereIn($field[1], $searchValue['value']);
                    } else {
                        $query->where($field[1], $searchValue['condition'], $searchValue['value']);
                    }
                });
            } else {
                if (is_array($searchValue['value'])) {
                    $model = $model->whereIn($field[0], $searchValue['value']);
                } else {
                    $model = $model->where($field[0], $searchValue['condition'], $searchValue['value']);
                }
            }
        }

        return $model;
    }
}
