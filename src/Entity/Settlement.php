<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settlement
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="settlement")
 */
class Settlement implements \JsonSerializable
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Region
     * @ORM\JoinColumn(name="region_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Region")
     */
    private $region_ID;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $settlementName;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $postalCode;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Region
     */
    public function getRegionID(): Region
    {
        return $this->region_ID;
    }

    /**
     * @param Region $region_ID
     */
    public function setRegionID(Region $region_ID): void
    {
        $this->region_ID = $region_ID;
    }

    /**
     * @return string
     */
    public function getSettlementName(): string
    {
        return $this->settlementName;
    }

    /**
     * @param string $settlementName
     */
    public function setSettlementName(string $settlementName): void
    {
        $this->settlementName = $settlementName;
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

    public function jsonSerialize()
    {
        return ["id" =>$this->id,"region_ID" => $this->region_ID, "settlementName" =>$this->settlementName, "postalCode" => $this->postalCode];
    }



}