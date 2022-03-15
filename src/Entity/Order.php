<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\JoinColumn(name="user_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user_ID;

    /**
     * @var Client
     * @ORM\JoinColumn(name="clientID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Client")
     */
    private $clientID;

    /**
     * @var Phone
     * @ORM\JoinColumn(name="phone_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Phone")
     */
    private $phone_ID;

    /**
     * @var Warehouse
     * @ORM\JoinColumn(name="warehouse_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Warehouse")
     */
    private $warehouse_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $price;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $orderNumber;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUserID(): User
    {
        return $this->user_ID;
    }

    /**
     * @param User $user_ID
     */
    public function setUserID(User $user_ID): void
    {
        $this->user_ID = $user_ID;
    }

    /**
     * @return Client
     */
    public function getClientID(): Client
    {
        return $this->clientID;
    }

    /**
     * @param Client $clientID
     */
    public function setClientID(Client $clientID): void
    {
        $this->clientID = $clientID;
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
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }










}