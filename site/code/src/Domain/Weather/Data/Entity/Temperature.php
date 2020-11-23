<?php
namespace App\Domain\Weather\Data\Entity;

/**
 * Class Temperature
 *
 * @package App\Domain\Weather\Entity
 */
class Temperature
{
    /** @var int */
    private $id;
    /** @var \DateTime */
    private $date;
    /** @var float */
    private $value;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
    public function getValue(): float
    {
        return $this->value;
    }
    
    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }
    
}
