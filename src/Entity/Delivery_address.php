<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Delivery_address
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="delivery_address")
 */
class Delivery_address
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Client
     * @ORM\JoinColumn(name="client_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Client")
     */
    private $client_ID;

    /**
     * @var Settlement
     * @ORM\JoinColumn(name="settlement_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Settlement")
     */
    private $settlement_ID;


    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $address;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Client
     */
    public function getClientID(): Client
    {
        return $this->client_ID;
    }

    /**
     * @param Client $client_ID
     */
    public function setClientID(Client $client_ID): void
    {
        $this->client_ID = $client_ID;
    }

    /**
     * @return Settlement
     */
    public function getSettlementID(): Settlement
    {
        return $this->settlement_ID;
    }

    /**
     * @param Settlement $settlement_ID
     */
    public function setSettlementID(Settlement $settlement_ID): void
    {
        $this->settlement_ID = $settlement_ID;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }









}