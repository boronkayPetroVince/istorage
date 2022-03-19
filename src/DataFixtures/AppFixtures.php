<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\User;
use App\Entity\Stock;
use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Country;
use App\Entity\Warehouse;
use App\Entity\Order;
use App\Entity\Deliveryaddress;
use App\Entity\Color;
use App\Entity\Phone;
use App\Entity\City;
use App\Entity\Client;
use App\Kernel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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


        //FELHASZNÁLÓ - RAKTÁROS
        $felhasznalo = new User();
        $felhasznalo->setTelNev("Czobori Effi");
        $felhasznalo->setFelhNev("PetroTheGod");
        $felhasznalo->setJelszo("12345");
        $felhasznalo->setTelefonszam(06305506453);
        $felhasznalo->setEmail("petrogod@gmail.com");
        $felhasznalo->setRoles(["ROLE_ADMIN"]);
        $this->em->persist($felhasznalo);

        $this->em->flush();
    }



}
