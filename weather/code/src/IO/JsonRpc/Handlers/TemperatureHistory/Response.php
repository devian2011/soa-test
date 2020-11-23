<?php

namespace App\IO\JsonRpc\Handlers\TemperatureHistory;

use App\Entity\TemperatureHistory;
use IO\JsonRpc\Exception\WrongResponseBuilderInputDataException;

/**
 * Class Response
 *
 * @package IO\JsonRpc\Handlers\TemperatureHistory
 */
class Response implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data;
    
    /**
     * Response constructor.
     *
     * @param array $temperatureHistory
     *
     * @throws WrongResponseBuilderInputDataException
     */
    public function __construct(array $temperatureHistory)
    {
        foreach ($temperatureHistory as $v) {
            if (!$v instanceof TemperatureHistory) {
                throw new WrongResponseBuilderInputDataException("Wrong input data at TemperatureHistory Response Builder");
            }
            $this->data[] = [
                'id'          => $v->getId(),
                'date'        => $v->getDateAt()->format('Y-m-d'),
                'temperature' => $v->getTemp(),
            ];
        }
    }
    
    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
    
    
}
