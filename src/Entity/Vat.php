<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Vat
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="Vat")
 */
class Vat implements \JsonSerializable
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
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $vatPercent;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getVatRate(): string
    {
        return $this->vatPercent;
    }

    /**
     * @param string $vatPercent
     */
    public function setVatRate(string $vatPercent): void
    {
        $this->vatPercent = $vatPercent;
    }

    public function jsonSerialize()
    {
        return ["id" => $this->id, "vatRate" => $this->vatPercent];
    }


}