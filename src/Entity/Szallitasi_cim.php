<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Szallitasi_cim
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="szallitasi_cim")
 */
class Szallitasi_cim
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Ugyfel
     * @ORM\JoinColumn(name="ugyfel_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Ugyfel")
     */
    private $ugyfel_ID;

    /**
     * @var Telepules
     * @ORM\JoinColumn(name="telepules_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Telepules")
     */
    private $telepules_ID;


    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $utca_hazszam;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Ugyfel
     */
    public function getUgyfelID(): Ugyfel
    {
        return $this->ugyfel_ID;
    }

    /**
     * @param Ugyfel $ugyfel_ID
     */
    public function setUgyfelID(Ugyfel $ugyfel_ID): void
    {
        $this->ugyfel_ID = $ugyfel_ID;
    }

    /**
     * @return Telepules
     */
    public function getTelepulesID(): Telepules
    {
        return $this->telepules_ID;
    }

    /**
     * @param Telepules $telepules_ID
     */
    public function setTelepulesID(Telepules $telepules_ID): void
    {
        $this->telepules_ID = $telepules_ID;
    }

    /**
     * @return string|null
     */
    public function getUtcaHazszam(): ?string
    {
        return $this->utca_hazszam;
    }

    /**
     * @param string|null $utca_hazszam
     */
    public function setUtcaHazszam(?string $utca_hazszam): void
    {
        $this->utca_hazszam = $utca_hazszam;
    }






}