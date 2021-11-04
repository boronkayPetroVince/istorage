<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Stock
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="stock")
 */
class Stock
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Warehouse
     * @ORM\JoinColumn(name="warehouse_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Warehouse")
     */
    private $warehouse_ID;

    /**
     * @var Phone
     * @ORM\JoinColumn(name="phone_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Phone")
     */
    private $phone_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $purchase_price;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Warehouse
     */
    public function getWarehouseID(): Warehouse
    {
        return $this->warehouse_ID;
    }

    /**
     * @param Warehouse $warehouse_ID
     */
    public function setWarehouseID(Warehouse $warehouse_ID): void
    {
        $this->warehouse_ID = $warehouse_ID;
    }

    /**
     * @return Phone
     */
    public function getPhoneID(): Phone
    {
        return $this->phone_ID;
    }

    /**
     * @param Phone $phone_ID
     */
    public function setPhoneID(Phone $phone_ID): void
    {
        $this->phone_ID = $phone_ID;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getPurchasePrice(): int
    {
        return $this->purchase_price;
    }

    /**
     * @param int $purchase_price
     */
    public function setPurchasePrice(int $purchase_price): void
    {
        $this->purchase_price = $purchase_price;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }







}