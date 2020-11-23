<?php

namespace App\Domain\Weather\Dto;

use App\Domain\Weather\Data\Entity\Temperature;

/**
 * Class TemperatureDto
 *
 * @package Domain\Weather\Dto
 */
class TemperatureListDto implements \Iterator
{
    /**
     * @var TemperatureDto[]
     */
    private $collection;
    
    /**
     * TemperatureListDto constructor.
     *
     * @param Temperature[] $temperatures
     */
    public function __construct(array $temperatures)
    {
        foreach ($temperatures as $temperature) {
            $this->add(new TemperatureDto($temperature));
        }
    }
    
    /**
     * @param TemperatureDto $temperatureDto
     */
    public function add(TemperatureDto $temperatureDto)
    {
        $this->collection[$temperatureDto->getDate()->format('dmyHis')] = $temperatureDto;
    }
    
    public function next()
    {
        next($this->collection);
    }
    
    public function key()
    {
        return key($this->collection);
    }
    
    public function valid()
    {
        $current = $this->current();
        return !empty($current);
    }
    
    public function current()
    {
        return current($this->collection);
    }
    
    public function rewind()
    {
        reset($this->collection);
    }
    
    
}
