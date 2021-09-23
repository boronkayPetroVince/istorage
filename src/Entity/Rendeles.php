<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Rendeles
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="rendeles")
 */
class Rendeles
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Felhasznalo
     * @ORM\JoinColumn(name="felhasz_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Felhasznalo")
     */
    private $felhasz_ID;

    /**
     * @var Szallitasi_cim
     * @ORM\JoinColumn(name="szallitas_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Szallitasi_cim")
     */
    private $szallitas_ID;

    /**
     * @var Telefon
     * @ORM\JoinColumn(name="telefon_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Telefon")
     */
    private $telefon_ID;

    /**
     * @var Raktar
     * @ORM\JoinColumn(name="raktar_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Raktar")
     */
    private $raktar_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $rendel_DB;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $elad_ar;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $mikor;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $statusz;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return Felhasznalo
     */
    public function getFelhaszID(): Felhasznalo
    {
        return $this->felhasz_ID;
    }

    /**
     * @param Felhasznalo $felhasz_ID
     */
    public function setFelhaszID(Felhasznalo $felhasz_ID): void
    {
        $this->felhasz_ID = $felhasz_ID;
    }

    /**
     * @return Szallitasi_cim
     */
    public function getSzallitasID(): Szallitasi_cim
    {
        return $this->szallitas_ID;
    }

    /**
     * @param Szallitasi_cim $szallitas_ID
     */
    public function setSzallitasID(Szallitasi_cim $szallitas_ID): void
    {
        $this->szallitas_ID = $szallitas_ID;
    }

    /**
     * @return Telefon
     */
    public function getTelefonID(): Telefon
    {
        return $this->telefon_ID;
    }

    /**
     * @param Telefon $telefon_ID
     */
    public function setTelefonID(Telefon $telefon_ID): void
    {
        $this->telefon_ID = $telefon_ID;
    }

    /**
     * @return Raktar
     */
    public function getRaktarID(): Raktar
    {
        return $this->raktar_ID;
    }

    /**
     * @param Raktar $raktar_ID
     */
    public function setRaktarID(Raktar $raktar_ID): void
    {
        $this->raktar_ID = $raktar_ID;
    }

    /**
     * @return int
     */
    public function getRendelDB(): int
    {
        return $this->rendel_DB;
    }

    /**
     * @param int $rendel_DB
     */
    public function setRendelDB(int $rendel_DB): void
    {
        $this->rendel_DB = $rendel_DB;
    }

    /**
     * @return int
     */
    public function getEladAr(): int
    {
        return $this->elad_ar;
    }

    /**
     * @param int $elad_ar
     */
    public function setEladAr(int $elad_ar): void
    {
        $this->elad_ar = $elad_ar;
    }

    /**
     * @return \DateTime
     */
    public function getMikor(): \DateTime
    {
        return $this->mikor;
    }

    /**
     * @param \DateTime $mikor
     */
    public function setMikor(\DateTime $mikor): void
    {
        $this->mikor = $mikor;
    }

    /**
     * @return string
     */
    public function getStatusz(): string
    {
        return $this->statusz;
    }

    /**
     * @param string $statusz
     */
    public function setStatusz(string $statusz): void
    {
        $this->statusz = $statusz;
    }




}