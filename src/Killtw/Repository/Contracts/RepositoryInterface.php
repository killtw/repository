<?php

namespace Killtw\Repository\Contracts;

/**
 * Interface RepositoryInterface
 *
 * @package Killtw\Repository\Contracts
 */
interface RepositoryInterface
{
    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param null $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($perPage = null, $columns = ['*']);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $id
     * @param string $field
     *
     * @return mixed
     */
    public function update(array $data, $id, $field = 'id');

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * @param array|string $relations
     *
     * @return mixed
     */
    public function with($relations);

    /**
     * @return mixed
     */
    public function getSearchableFields();
}
