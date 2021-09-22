<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="model")
 */
class Model
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Marka
     * @ORM\JoinColumn(name="marka_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Marka")
     */
    private $marka_ID;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $model;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Marka
     */
    public function getMarkaID(): Marka
    {
        return $this->marka_ID;
    }

    /**
     * @param Marka $marka_ID
     */
    public function setMarkaID(Marka $marka_ID): void
    {
        $this->marka_ID = $marka_ID;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }


}