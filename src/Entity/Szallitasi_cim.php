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
     * @var string|null
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $orszag;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $varos;

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
     * @return string|null
     */
    public function getOrszag(): ?string
    {
        return $this->orszag;
    }

    /**
     * @param string|null $orszag
     */
    public function setOrszag(?string $orszag): void
    {
        $this->orszag = $orszag;
    }

    /**
     * @return string|null
     */
    public function getVaros(): ?string
    {
        return $this->varos;
    }

    /**
     * @param string|null $varos
     */
    public function setVaros(?string $varos): void
    {
        $this->varos = $varos;
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