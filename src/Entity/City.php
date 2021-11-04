<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class City
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="city")
 */
class City
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Country
     * @ORM\JoinColumn(name="country_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Country")
     */
    private $country_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $postalCode;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $cityName;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Country
     */
    public function getCountryID(): Country
    {
        return $this->country_ID;
    }

    /**
     * @param Country $country_ID
     */
    public function setCountryID(Country $country_ID): void
    {
        $this->country_ID = $country_ID;
    }

    /**
     * @return int
     */
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * @param int $postalCode
     */
    public function setPostalCode(int $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }




}