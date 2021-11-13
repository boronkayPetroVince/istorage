<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Client
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class Client implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return ["id"=>$this->id,"clientName" => $this->clientName, "vatNumber" => $this->vatNumber];
    }

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
    private $clientName;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $vatNumber;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vatNumberEU;

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
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * @return int
     */
    public function getVatNumber(): int
    {
        return $this->vatNumber;
    }

    /**
     * @param int $vatNumber
     */
    public function setVatNumber(int $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * @return int|null
     */
    public function getVatNumberEU(): ?int
    {
        return $this->vatNumberEU;
    }

    /**
     * @param int|null $vatNumberEU
     */
    public function setVatNumberEU(?int $vatNumberEU): void
    {
        $this->vatNumberEU = $vatNumberEU;
    }





}