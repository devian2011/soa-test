<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Temperature
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass="\App\Repository\TemperatureHistoryRepository")
 * @ORM\Table(name="history", indexes={@ORM\Index(name="temp_history_date_idx", columns={"date_at"})})
 */
class TemperatureHistory
{
    
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var float
     * @ORM\Column(type="float", name="temp")
     */
    private $temp;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="date", name="date_at")
     */
    private $dateAt;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return float
     */
    public function getTemp()
    {
        return $this->temp;
    }
    
    /**
     * @param float $temp
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;
    }
    
    /**
     * @return \DateTime
     */
    public function getDateAt()
    {
        return $this->dateAt;
    }
    
    /**
     * @param \DateTime $dateAt
     */
    public function setDateAt($dateAt)
    {
        $this->dateAt = $dateAt;
    }
    
}
