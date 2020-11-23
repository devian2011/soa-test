<?php

namespace App\Domain\Weather\Services;


use App\Domain\Weather\Data\Providers\WeatherProviderInterface;
use App\Domain\Weather\Contracts\FindByDateRequestContract;
use App\Domain\Weather\Dto\TemperatureDto;
use App\Domain\Weather\Dto\TemperatureListDto;

/**
 * Class ForecastFinder
 *
 * @package App\Domain\Weather\Services
 */
class TemperatureFinder
{
    
    private const TEMPERATURE_LAST_DAYS = 30;
    
    /** @var WeatherProviderInterface */
    private $provider;
    
    /**
     * ForecastFinder constructor.
     *
     * @param WeatherProviderInterface $provider
     */
    public function __construct(WeatherProviderInterface $provider)
    {
        $this->provider = $provider;
    }
    
    /**
     * @return TemperatureListDto лучше бы отсюда возвращать интерфес, но для тестового задания пойдёт
     */
    public function findForLastDays(): TemperatureListDto
    {
        $temperatures = $this->provider->getTemperatureDataHistory(self::TEMPERATURE_LAST_DAYS);
        return new TemperatureListDto($temperatures);
    }
    
    /**
     * @param FindByDateRequestContract $contract
     *
     * @return TemperatureDto лучше бы отсюда возвращать интерфес, но для тестового задания пойдёт
     */
    public function findByDate(FindByDateRequestContract $contract): TemperatureDto
    {
        $temperature = $this->provider->getTemperatureForDate($contract->getDate());
        return new TemperatureDto($temperature);
    }
    
}
