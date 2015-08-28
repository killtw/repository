<?php
namespace Killtw\Repository\Presenter;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\AbstractPaginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\SerializerAbstract;
use Killtw\Repository\Contracts\PresenterInterface;

/**
 * Class FractalPresenter
 *
 * @package Killtw\Repository\Presenter
 */
abstract class FractalPresenter implements PresenterInterface
{
    /**
     * @var Manager
     */
    protected $fractal;
    /**
     * @var null
     */
    protected $resource = null;

    /**
     * FractalPresenter constructor.
     */
    public function __construct()
    {
        $this->fractal = new Manager();
        $this->setUpSerializer();
    }

    /**
     * @return $this
     */
    private function setUpSerializer()
    {
        $serializer = $this->serializer();
        if ($serializer instanceof SerializerAbstract) {
            $this->fractal->setSerializer($serializer);
        }

        return $this;
    }

    /**
     * @return DataArraySerializer
     */
    private function serializer()
    {
        return new DataArraySerializer();
    }

    /**
     * @return mixed
     */
    abstract public function getTransformer();

    /**
     * @param $data
     *
     * @return array
     */
    public function present($data)
    {
        if ($data instanceof EloquentCollection) {
            $this->resource = $this->transformCollection($data);
        } elseif ($data instanceof AbstractPaginator) {
            $this->resource = $this->transformPaginator($data);
        } else {
            $this->resource = $this->transformItem($data);
        }

        return $this->fractal->createData($this->resource)->toArray();
    }

    /**
     * @param EloquentCollection $data
     *
     * @return Collection
     */
    private function transformCollection(EloquentCollection $data)
    {
        return new Collection($data, $this->getTransformer());
    }

    /**
     * @param AbstractPaginator $data
     *
     * @return Collection
     */
    private function transformPaginator(AbstractPaginator $data)
    {
        $collection = $data->getCollection();
        $resource = new Collection($collection, $this->getTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($data));

        return $resource;
    }

    /**
     * @param $data
     *
     * @return Item
     */
    private function transformItem($data)
    {
        return new Item($data, $this->getTransformer());
    }
}
