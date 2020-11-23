<?php

namespace App\DataFixtures;

use App\Entity\TemperatureHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $currentDate = new \DateTime();
        
        $period = new \DatePeriod(
            (clone $currentDate)->sub(new \DateInterval('P6M')),
            new \DateInterval('P1D'),
            $currentDate
        );
        
        foreach ($period as $date) {
            $temperature = new TemperatureHistory();
            $temperature->setDateAt($date);
            $temperature->setTemp(mt_rand(-300, 200) / 10);
            $manager->persist($temperature);
        }
        
        $manager->flush();
    }
}
