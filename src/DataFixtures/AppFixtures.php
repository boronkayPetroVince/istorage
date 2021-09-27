<?php

namespace App\DataFixtures;

use App\Entity\Elerhetoseg;
use App\Entity\Felhasznalo;
use App\Entity\Keszlet;
use App\Entity\Marka;
use App\Entity\Modell;
use App\Entity\Raktar;
use App\Entity\Rendeles;
use App\Entity\Szallitasi_cim;
use App\Entity\Telefon;
use App\Entity\Ugyfel;
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
        $marka = new Marka();
        $marka->setMarka("Anyáááád");
        $this->em->persist($marka);

        $modell = new Modell();
        $modell->setModel("XI");
        $modell->setMarkaID($marka);
        $this->em->persist($modell);

        $telefon = new Telefon();
        $telefon->setModelID($modell);
        $telefon->setMeretGB(64);
        $telefon->setSzin("Fekete");
        $this->em->persist($telefon);

        // ÜGYFÉL
        $ugyfel = new Ugyfel();
        $ugyfel->setCegnev("PetroSoft");
        $ugyfel->setAdoszam(1234565-4-13);
        $this->em->persist($ugyfel);

        $szallitasi_cim = new Szallitasi_cim();
        $szallitasi_cim->setOrszag("Magyarország");
        $szallitasi_cim->setVaros("Vác");
        $szallitasi_cim->setUtcaHazszam("Bottyán utca 17.");
        $szallitasi_cim->setUgyfelID($ugyfel);
        $this->em->persist($szallitasi_cim);

        $elerhetoseg = new Elerhetoseg();
        $elerhetoseg->setTelNev("Petróleum Vince");
        $elerhetoseg->setEmail("petroking@gmail.com");
        $elerhetoseg->setTelefonszam(06305506354);
        $elerhetoseg->setUgyfelID($ugyfel);
        $this->em->persist($elerhetoseg);

        //FELHASZNÁLÓ - RAKTÁROS
        $felhasznalo = new Felhasznalo();
        $felhasznalo->setTelNev("Czobori Effi");
        $felhasznalo->setFelhNev("PetroTheGod");
        $felhasznalo->setJelszo("12345");
        $felhasznalo->setTelefonszam(06305506453);
        $felhasznalo->setEmail("petrogod@gmail.com");
        $felhasznalo->setRoles(["ROLE_ADMIN"]);
        $this->em->persist($felhasznalo);

        // RAKTÁR - RENDELÉS
        $raktar = new Raktar();
        $raktar->setHelyszin("Budapest");
        $raktar->setKapacitas(1000);
        $this->em->persist($raktar);

        $keszlet = new Keszlet();
        $keszlet->setTelefonID($telefon);
        $keszlet->setRaktarID($raktar);
        $keszlet->setBeszerszAr(5000);
        $keszlet->setMennyiseg(500);
        $keszlet->setElerhetoE("Igen");
        $this->em->persist($keszlet);

        $rendeles = new Rendeles();
        $rendeles->setRaktarID($raktar);
        $rendeles->setFelhaszID($felhasznalo);
        $rendeles->setSzallitasID($szallitasi_cim);
        $rendeles->setTelefonID($telefon);
        $rendeles->setRendelDB(100);
        $rendeles->setEladAr(10000);
        $rendeles->setStatusz("Átadva!");
        $this->em->persist($rendeles);

        $this->em->flush();
    }



}
