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

        // TELEFON
        $marka = new Brand();
        $marka->setMarka("IPhone");
        $this->em->persist($marka);

        $model = new Model();
        $model->setModel("XI");
        $model->setMarkaID($marka);
        $this->em->persist($model);

        $szin = new Color();
        $szin->setSzin("Fehér");
        $this->em->persist($szin);

        $telefon = new Phone();
        $telefon->setModelID($model);
        $telefon->setMeretGB(64);
        $telefon->setSzinID($szin);
        $this->em->persist($telefon);

        // ÜGYFÉL
        $ugyfel = new Client();
        $ugyfel->setCegnev("PetroSoft");
        $ugyfel->setAdoszam(1234565-4-13);
        $this->em->persist($ugyfel);

        $orszag = new Country();
        $orszag->setOrszag("Magyarország");
        $this->em->persist($orszag);

        $telepules = new City();
        $telepules->setOrszagID($orszag);
        $telepules->setIranyitoszam(2600);
        $telepules->setTelepules("Vác");
        $this->em->persist($telepules);

        $szallitasi_cim = new Deliveryaddress();
        $szallitasi_cim->setTelepulesID($telepules);
        $szallitasi_cim->setUtcaHazszam("Bottyán utca 17.");
        $szallitasi_cim->setUgyfelID($ugyfel);
        $this->em->persist($szallitasi_cim);

        $elerhetoseg = new Contact();
        $elerhetoseg->setTelNev("Petróleum Vince");
        $elerhetoseg->setEmail("petroking@gmail.com");
        $elerhetoseg->setTelefonszam(06305506354);
        $elerhetoseg->setUgyfelID($ugyfel);
        $this->em->persist($elerhetoseg);

        //FELHASZNÁLÓ - RAKTÁROS
        $felhasznalo = new User();
        $felhasznalo->setTelNev("Czobori Effi");
        $felhasznalo->setFelhNev("PetroTheGod");
        $felhasznalo->setJelszo("12345");
        $felhasznalo->setTelefonszam(06305506453);
        $felhasznalo->setEmail("petrogod@gmail.com");
        $felhasznalo->setRoles(["ROLE_ADMIN"]);
        $this->em->persist($felhasznalo);

        // RAKTÁR - RENDELÉS
        $raktar = new Warehouse();
        $raktar->setHelyszin("Budapest");
        $raktar->setKapacitas(1000);
        $this->em->persist($raktar);

        $keszlet = new Stock();
        $keszlet->setTelefonID($telefon);
        $keszlet->setRaktarID($raktar);
        $keszlet->setBeszerszAr(5000);
        $keszlet->setMennyiseg(500);
        $keszlet->setElerhetoE("Igen");
        $this->em->persist($keszlet);

        $rendeles = new Order();
        $rendeles->setRaktarID($raktar);
        $rendeles->setFelhaszID($felhasznalo);
        $rendeles->setSzallitasID($szallitasi_cim);
        $rendeles->setTelefonID($telefon);
        $rendeles->setRendelDB(100);
        $rendeles->setEladAr(10000);
        $rendeles->setMikor(new \DateTime());
        $rendeles->setStatusz("Átadva!");
        $this->em->persist($rendeles);

        $this->em->flush();
    }



}
