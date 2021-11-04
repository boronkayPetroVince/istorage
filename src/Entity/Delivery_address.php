<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Deliveryaddress
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
     * @var City
     * @ORM\JoinColumn(name="city_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="City")
     */
    private $city_ID;


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
     * @return City
     */
    public function getCityID(): City
    {
        return $this->city_ID;
    }

    /**
     * @param City $city_ID
     */
    public function setCityID(City $city_ID): void
    {
        $this->city_ID = $city_ID;
    }

    /**
     * @return string|null
     */
    public function getaddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setaddress(?string $address): void
    {
        $this->address = $address;
    }







}