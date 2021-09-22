<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Elerhetoseg
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="elerhetoseg")
 */
class Elerhetoseg
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $telNev;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $telefonszam;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

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
    public function getTelNev(): ?string
    {
        return $this->telNev;
    }

    /**
     * @param string|null $telNev
     */
    public function setTelNev(?string $telNev): void
    {
        $this->telNev = $telNev;
    }

    /**
     * @return int
     */
    public function getTelefonszam(): int
    {
        return $this->telefonszam;
    }

    /**
     * @param int $telefonszam
     */
    public function setTelefonszam(int $telefonszam): void
    {
        $this->telefonszam = $telefonszam;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


}