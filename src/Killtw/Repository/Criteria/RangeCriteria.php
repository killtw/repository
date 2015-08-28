<?php

namespace Killtw\Repository\Criteria;

use Carbon\Carbon;
use Killtw\Repository\Contracts\CriteriaInterface;
use Killtw\Repository\Contracts\RepositoryInterface;

/**
 * Class RangeCriteria
 *
 * @package Killtw\Repository\Criteria
 */
class RangeCriteria implements CriteriaInterface
{
    /**
     * @var array|string
     */
    private $dateRange;
    /**
     * @var string
     */
    private $start_field;
    /**
     * @var null|string
     */
    private $end_field;
    /**
     * @var Carbon
     */
    private $carbon;

    /**
     * rangeCriteria constructor.
     *
     * @param array|string $dateRange
     * @param string $start_field
     * @param string|null $end_field
     */
    public function __construct($dateRange, $start_field = 'created_at', $end_field = null)
    {
        $this->dateRange = $dateRange;
        $this->start_field = $start_field;
        $this->end_field = $end_field ?: $start_field;
        $this->carbon = new Carbon();
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        sort($this->getDateRange());
        list($start, $end) = $this->getDateRange();

        return $model->where($this->end_field, '>=', $start)->where($this->start_field, '<=', $end);
    }

    /**
     * @return array
     */
    private function getDateRange()
    {
        if (is_array($this->dateRange)) return $this->dateRange;

        switch (strtolower($this->dateRange)) {
            case 'today':
                return [$this->carbon->today(), $this->carbon->tomorrow()];
            case 'yesterday':
                return [$this->carbon->yesterday(), $this->carbon->today()];
            case 'thisweek':
                return [
                    ($this->carbon->today()->dayOfWeek === 0) ? $this->carbon->today() : $this->carbon->today()->previous(0),
                    $this->carbon->tomorrow()
                ];
            case 'lastweek':
                return [
                    ($this->carbon->today()->dayOfWeek === 0) ?
                        $this->carbon->today()->previous(0) :
                        $this->carbon->today()->previous(0)->previous(),
                    $this->carbon->today()->previous(6)->addDay()
                ];
            case 'thismonth':
                return [
                    $this->carbon->today()->startOfMonth(),
                    $this->carbon->tomorrow()
                ];
            case 'lastmonth':
                return [
                    $this->carbon->today()->subMonth()->startOfMonth(),
                    $this->carbon->today()->subMonth()->endOfMonth()
                ];
        }
    }
}
