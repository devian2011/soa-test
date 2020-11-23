<?php

namespace App\Services\Temperature;

use App\Entity\TemperatureHistory;
use App\Repository\TemperatureHistoryRepository;

/**
 * Class TemperatureHistoryGetter
 *
 * @package Services\Temperature
 */
class TemperatureHistoryGetter
{
    
    /** @var TemperatureHistoryRepository */
    private $repo;
    
    /**
     * TemperatureHistoryGetter constructor.
     *
     * @param TemperatureHistoryRepository $repository
     */
    public function __construct(TemperatureHistoryRepository $repository)
    {
        $this->repo = $repository;
    }
    
    /**
     * @param \DateTime $dateTime
     *
     * @return TemperatureHistory
     * @throws \App\Repository\UnknownTemperatureHistoryException
     */
    public function findByDate(\DateTime $dateTime)
    {
        return $this->repo->findByDate($dateTime);
    }
    
    /**
     * @param int $offset
     *
     * @return TemperatureHistory[]
     */
    public function findHistoryLimitedList(int $limit)
    {
        return $this->repo->getHistoryLimitedList($limit);
    }
    
}
