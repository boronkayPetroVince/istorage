<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ContainerInterface
     */
    private $container;



    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $kernel = $this->container->get('kernel');
        if($kernel) $this->environment = $kernel->getEnvironment();
    }
    public function load(ObjectManager $manager)
    {
        $this->em = $manager;
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setFullName("Petró Vince");
        $user->setUsername("petro");
        $user->setPassword(password_hash("123", PASSWORD_ARGON2ID));
        $user->setPhoneNumber("+36305506454");
        $user->setEmail("petro.vince.2001@tanulo.boronkay.hu");
        $user->setRoles(["ROLE_ADMIN"]);
        $this->em->persist($user);

        $this->em->flush();
    }



}
