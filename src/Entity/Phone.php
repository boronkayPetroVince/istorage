<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Phone
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="phone")
 */
class Phone
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Model
     * @ORM\JoinColumn(name="model_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Model")
     */
    private $model_ID;

    /**
     * @var Color
     * @ORM\JoinColumn(name="color_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Color")
     */
    private $color_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $storageGB;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return Model
     */
    public function getModelID(): Model
    {
        return $this->model_ID;
    }

    /**
     * @param Model $model_ID
     */
    public function setModelID(Model $model_ID): void
    {
        $this->model_ID = $model_ID;
    }

    /**
     * @return Color
     */
    public function getColorID(): Color
    {
        return $this->color_ID;
    }

    /**
     * @param Color $color_ID
     */
    public function setColorID(Color $color_ID): void
    {
        $this->color_ID = $color_ID;
    }

    /**
     * @return int
     */
    public function getStorageGB(): int
    {
        return $this->storageGB;
    }

    /**
     * @param int $storageGB
     */
    public function setStorageGB(int $storageGB): void
    {
        $this->storageGB = $storageGB;
    }






}