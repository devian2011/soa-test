<?php


namespace App\IO\JsonRpc\Handlers\TemperatureForDate;

use Symfony\Component\Validator\Constraints as Assert;

class Request
{
    
    /**
     * @var string
     * @Assert\Date
     * @Assert\NotBlank
     */
    private $date;
    
    /**
     * TemperatureForDateRequest constructor.
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->date = empty($input['date']) ? null : $input['date'];
    }
    
    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d', $this->date);
    }
    
    
}
