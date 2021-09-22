<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Keszlet
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="keszlet")
 */
class Keszlet
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Raktar
     * @ORM\JoinColumn(name="raktar_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Raktar")
     */
    private $raktar_ID;

    /**
     * @var Telefon
     * @ORM\JoinColumn(name="telefon_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Telefon")
     */
    private $telefon_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $mennyiseg;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $beszersz_ar;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $elerheto_e;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return int
     */
    public function getMennyiseg(): int
    {
        return $this->mennyiseg;
    }

    /**
     * @param int $mennyiseg
     */
    public function setMennyiseg(int $mennyiseg): void
    {
        $this->mennyiseg = $mennyiseg;
    }

    /**
     * @return int
     */
    public function getBeszerszAr(): int
    {
        return $this->beszersz_ar;
    }

    /**
     * @param int $beszersz_ar
     */
    public function setBeszerszAr(int $beszersz_ar): void
    {
        $this->beszersz_ar = $beszersz_ar;
    }

    /**
     * @return string
     */
    public function getElerhetoE(): string
    {
        return $this->elerheto_e;
    }

    /**
     * @param string $elerheto_e
     */
    public function setElerhetoE(string $elerheto_e): void
    {
        $this->elerheto_e = $elerheto_e;
    }




}