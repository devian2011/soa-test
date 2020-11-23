<?php

namespace App\Domain\Weather\Data\Providers;

use App\Domain\Weather\Data\Entity\Temperature;

/**
 * Interface WeatherProviderInterface
 *
 * @package App\Domain\Weather\Providers
 */
interface WeatherProviderInterface
{
    
    /**
     * @param int $offset Days offset
     *
     * @return Temperature[]
     */
    public function getTemperatureDataHistory(int $offset): array;
    
    /**
     * @param \DateTime $date
     *
     * @return Temperature
     */
    public function getTemperatureForDate(\DateTime $date): Temperature;
    
}
