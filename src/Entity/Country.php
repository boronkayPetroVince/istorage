<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Country
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="country")
 */
class Country implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return ["id" => $this->id, "country_name" => $this->countryName];
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
    private $countryName;

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
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName(string $countryName): void
    {
        $this->countryName = $countryName;
    }





}