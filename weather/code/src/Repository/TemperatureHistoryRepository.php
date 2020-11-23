<?php

namespace App\Repository;


use App\Entity\TemperatureHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TemperatureRepository
 *
 * @package App\Repository
 */
class TemperatureHistoryRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemperatureHistory::class);
    }
    
    /**
     * @param \DateTime $dateTime
     *
     * @return TemperatureHistory
     * @throws UnknownTemperatureHistoryException
     */
    public function findByDate(\DateTime $dateTime)
    {
        /** @var TemperatureHistory|null $result */
        $result = $this->findOneBy(['dateAt' => $dateTime]);
        if (empty($result)) {
            throw new UnknownTemperatureHistoryException("Unknown temperature in date: {$dateTime->format('Y-m-d')}");
        }
        
        return $result;
    }
    
    /**
     * @param int $offset
     *
     * @return TemperatureHistory[]
     */
    public function getHistoryLimitedList(int $limit)
    {
        return $this->findBy([], ['id' => 'DESC'], $limit, 0);
    }
    
}
