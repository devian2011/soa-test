<?php

namespace App\IO\Http\Weather\Response;

use App\Domain\Weather\Dto\TemperatureDto;

/**
 * Class TemperatureResponse
 *
 * @package App\IO\Http\Weather\Response
 */
class TemperatureResponse implements \JsonSerializable
{
    /**
     * @var TemperatureDto
     */
    private $dto;
    
    /**
     * TemperatureResponse constructor.
     *
     * @param TemperatureDto $temperatureDto
     */
    public function __construct(TemperatureDto $temperatureDto)
    {
        $this->dto = $temperatureDto;
    }
    
    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'temp' => $this->getTemp(),
            'date' => $this->getDate(),
        ];
    }
    
    /**
     * @return float
     */
    public function getTemp()
    {
        return $this->dto->getTemp();
    }
    
    /**
     * @return string
     */
    public function getDate()
    {
        return $this->dto->getDate()->format('d.m.Y');
    }
    
}
