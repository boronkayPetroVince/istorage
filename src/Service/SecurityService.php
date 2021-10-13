<?php


namespace App\Service;


use App\Entity\Felhasznalo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * SecurityService constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }
    public function getAllFelhasznalo():iterable{
        return $this->em->getRepository(Felhasznalo::class)->findAll();
    }
    public function getOneFelhasznaloById(int $id):Felhasznalo{
        return $this->em->getRepository(Felhasznalo::class)->find($id);
    }
    public function addFelhasznalo(string $felh, string $jelszo, string $telNev, string $email, int $telefonszam, string $role):void{
        $felhasznalo = new Felhasznalo();
        $felhasznalo->setFelhNev($felh);
        $felhasznalo->setJelszo($this->encoder->encodePassword($felhasznalo, $jelszo));
        $felhasznalo->setTelNev($telNev);
        $felhasznalo->setEmail($email);
        $felhasznalo->setTelefonszam($telefonszam);
        $felhasznalo->setRoles([$role]);
        $this->em->persist($felhasznalo);
        $this->em->flush();
    }
    public function updateFelhasznalo(int $id):void{
        $felhasznalo = $this->getOneFelhasznaloById($id);
        $this->em->persist($felhasznalo);
        $this->em->flush();
    }
    public function removeFelhasznalo(int $id):void{
        $this->em->remove($this->getOneFelhasznaloById($id));
        $this->em->flush();
    }
    public function checkPassword(string $felhNev, string $jelszo):bool{
        $felhasznalo = $this->em->getRepository(Felhasznalo::class)->findOneBy(["felhNev"=>$felhNev]);
        if (!$felhasznalo) return false;
        return $this->encoder->isPasswordValid($felhasznalo, $jelszo);
    }


}