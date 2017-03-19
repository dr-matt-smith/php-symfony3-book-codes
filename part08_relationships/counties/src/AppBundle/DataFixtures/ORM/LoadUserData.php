<?php


namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1= new User();
        $user1->setUsername('user1');
        $user1->setPassword('password');
        $user1->setCountyId(1);

        $user2= new User();
        $user2->setUsername('user2');
        $user2->setPassword('password2');
        $user2->setCountyId(2);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
}