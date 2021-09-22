<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Ugyfel
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="ugyfel")
 */
class Ugyfel
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $cegnev;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $adoszam;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $adoszam_EU;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getCegnev(): string
    {
        return $this->cegnev;
    }

    /**
     * @param string $cegnev
     */
    public function setCegnev(string $cegnev): void
    {
        $this->cegnev = $cegnev;
    }

    /**
     * @return int
     */
    public function getAdoszam(): int
    {
        return $this->adoszam;
    }

    /**
     * @param int $adoszam
     */
    public function setAdoszam(int $adoszam): void
    {
        $this->adoszam = $adoszam;
    }

    /**
     * @return int|null
     */
    public function getAdoszamEU(): ?int
    {
        return $this->adoszam_EU;
    }

    /**
     * @param int|null $adoszam_EU
     */
    public function setAdoszamEU(?int $adoszam_EU): void
    {
        $this->adoszam_EU = $adoszam_EU;
    }


}