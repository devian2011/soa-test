<?php

namespace App\Domain\Weather\Dto;

use App\Domain\Weather\Data\Entity\Temperature;

/**
 * Class TemperatureDto
 *
 * @package Domain\Weather\Dto
 */
class TemperatureDto
{
    /** @var \DateTime */
    private $date;
    
    /** @var float */
    private $temp;
    
    /**
     * TemperatureDto constructor.
     *
     * @param Temperature $temp
     */
    public function __construct(Temperature $temp)
    {
        $this->date = $temp->getDate();
        $this->temp = $temp->getValue();
    }
    
    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
    
    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
    
    /**
     * @return float
     */
    public function getTemp(): float
    {
        return $this->temp;
    }
    
    /**
     * @param float $temp
     */
    public function setTemp(float $temp): void
    {
        $this->temp = $temp;
    }
    
}
