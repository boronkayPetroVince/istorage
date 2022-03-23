<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Region
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="region")
 */
class Region implements \JsonSerializable
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
    private $region_name;

    /**
     * @var Country
     * @ORM\JoinColumn(name="country_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Country")
     */
    private $country_ID;

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
    public function getRegionName(): string
    {
        return $this->region_name;
    }

    /**
     * @param string $region_name
     */
    public function setRegionName(string $region_name): void
    {
        $this->region_name = $region_name;
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

    public function jsonSerialize()
    {
        return ["id" => $this->id, "country_ID" => $this->country_ID, "region_name" => $this->region_name];
    }
}