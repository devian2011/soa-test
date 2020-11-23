<?php

namespace App\Domain\Weather\Data\Providers\Service;

use App\Domain\Weather\Data\Entity\Temperature;
use App\Domain\Weather\Data\Providers\WeatherProviderInterface;
use App\Domain\Weather\Exceptions\WeatherServiceInvalidParamsException;

/**
 * Class WeatherServiceProvider
 *
 * @package App\Domain\Weather\Data\Providers\Service
 */
class WeatherServiceProvider implements WeatherProviderInterface
{
    /** @var WeatherServiceClient */
    private $client;
    
    /**
     * WeatherServiceProvider constructor.
     *
     * @param string $host
     * @param string $header
     * @param string $token
     */
    public function __construct(string $endpoint, string $header, string $token)
    {
        $this->client = new WeatherServiceClient($endpoint, $header, $token);
    }
    
    /**
     * @param int $offset
     *
     * @return array
     * @throws WeatherServiceInvalidParamsException
     * @throws \App\Domain\Weather\Exceptions\InvalidRequestResponseAssociationException
     * @throws \App\Domain\Weather\Exceptions\WeatherServiceUnavailableException
     */
    public function getTemperatureDataHistory(int $offset): array
    {
        $response = $this->client->sendRequest('weather.getHistory', ['lastDays' => $offset]);
        //Не охото писать полноценную обработку для тестового задания, так что пусть будет ad-hoc
        if ($response->hasErrors()) {
            throw new WeatherServiceInvalidParamsException("Invalid params for service");
        }
        $output = [];
        foreach ($response->getResult() as $item) {
            $temp = new Temperature();
            $temp->setId($item['id']);
            $temp->setDate(\DateTime::createFromFormat('Y-m-d', $item['date']));
            $temp->setValue($item['temperature']);
            $output[] = $temp;
        }
        
        return $output;
    }
    
    /**
     * @param \DateTime $date
     *
     * @return Temperature
     * @throws WeatherServiceInvalidParamsException
     * @throws \App\Domain\Weather\Exceptions\InvalidRequestResponseAssociationException
     * @throws \App\Domain\Weather\Exceptions\WeatherServiceUnavailableException
     */
    public function getTemperatureForDate(\DateTime $date): Temperature
    {
        $response = $this->client->sendRequest('weather.getByDate', ['date' => $date->format('Y-m-d')]);
        //Не охото писать полноценную обработку для тестового задания, так что пусть будет ad-hoc
        if ($response->hasErrors()) {
            throw new WeatherServiceInvalidParamsException($response->getErrorMessage());
        }
        $output = new Temperature();
        $output->setId($response->getResult()['id']);
        $output->setDate(\DateTime::createFromFormat('Y-m-d', $response->getResult()['date']));
        $output->setValue($response->getResult()['temp']);
        
        return $output;
    }
    
    
}
