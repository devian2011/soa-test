<?php

namespace App\IO\Http\Weather\Request;

use App\Domain\Weather\Contracts\FindByDateRequestContract;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TemperatureDayGetterRequest
 *
 * @package App\IO\Http\Weather\Request
 */
class TemperatureDayFinderRequest implements FindByDateRequestContract
{
    
    /**
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    public $date;
    
    /**
     * TemperatureDayGetterRequest constructor.
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->date = !empty($input['date']) ? $input['date'] : null;
    }
    
    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d', $this->date);
    }
    
    
}
