<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php
namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // create objects
        $userAdmin = $this->createActiveUser('admin', 'admin@admin.com', 'admin');
        $userMatt = $this->createActiveUser('matt', 'matt@matt.com', 'smith');
        // store to DB
        $manager->persist($userAdmin); $manager->persist($userMatt); $manager->flush();
    }

    private function createActiveUser($username, $email, $plainPassword):User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setIsActive(true);
        // password - and encoding
        $plainPassword = 'admin';
        $encodedPassword = $this->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        return $user;
    }

    private function encodePassword($user, $plainPassword):string
    {

        $encoder = $this->container->get('security.password_encoder');
        $encodedPassword = $encoder->encodePassword($user, $plainPassword);
        return $encodedPassword;
    }
}