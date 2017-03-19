<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\County;

class LoadCountyData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $county1 = new County();
        $county1->setName('Kildare');

        $county2 = new County();
        $county2->setName('Dublin');

        $manager->persist($county1);
        $manager->persist($county2);
        $manager->flush();
    }
}