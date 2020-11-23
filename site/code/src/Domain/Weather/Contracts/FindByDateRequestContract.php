<?php


namespace App\Domain\Weather\Contracts;

/**
 * Interface FindByDateRequestContract
 *
 * @package Domain\Weather\Contracts
 */
interface FindByDateRequestContract
{
    
    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime;
    
}
