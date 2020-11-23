<?php

namespace App\IO\JsonRpc\Handlers\TemperatureForDate;


use App\Entity\TemperatureHistory;

class Response implements \JsonSerializable
{
    /** @var TemperatureHistory */
    private $history;
    
    /**
     * Response constructor.
     *
     * @param TemperatureHistory $history
     */
    public function __construct(TemperatureHistory $history)
    {
        $this->history = $history;
    }
    
    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id'   => $this->history->getId(),
            'date' => $this->history->getDateAt()->format('Y-m-d'),
            'temp' => $this->history->getTemp(),
        ];
    }
    
    
}
