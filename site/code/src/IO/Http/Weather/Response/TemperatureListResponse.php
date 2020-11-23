<?php

namespace App\IO\Http\Weather\Response;

use App\Domain\Weather\Dto\TemperatureListDto;

/**
 * Class TemperatureList
 *
 * @package App\IO\Http\Weather\Response
 */
class TemperatureListResponse implements \Iterator
{
    /**
     * @var TemperatureListDto
     */
    private $dto;
    
    /**
     * TemperatureListResponse constructor.
     *
     * @param TemperatureListDto $dto
     */
    public function __construct(TemperatureListDto $dto)
    {
        $this->dto = $dto;
    }
    
    public function current()
    {
        $current = $this->dto->current();
        return new TemperatureResponse($current);
    }
    
    public function next()
    {
        $this->dto->next();
    }
    
    public function key()
    {
        return $this->dto->key();
    }
    
    public function valid()
    {
        return $this->dto->valid();
    }
    
    public function rewind()
    {
        $this->dto->rewind();
    }
    
    
}
