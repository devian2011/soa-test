<?php


namespace App\IO\JsonRpc\Handlers\TemperatureHistory;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TemperatureHistoryRequest
 *
 * @package IO\JsonRpc\Request
 */
class Request
{
    
    private const DEFAULT_HISTORY_LIMIT = 30;
    
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\PositiveOrZero()
     */
    private $limit;
    
    /**
     * TemperatureHistoryRequest constructor.
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->limit = !empty($input['lastDays']) ? $input['lastDays'] : self::DEFAULT_HISTORY_LIMIT;
    }
    
    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
    
}