<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Telefon
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="telefon")
 */
class Telefon
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
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $szin;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $meretGB;

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
     * @return string
     */
    public function getSzin(): string
    {
        return $this->szin;
    }

    /**
     * @param string $szin
     */
    public function setSzin(string $szin): void
    {
        $this->szin = $szin;
    }

    /**
     * @return int
     */
    public function getMeretGB(): int
    {
        return $this->meretGB;
    }

    /**
     * @param int $meretGB
     */
    public function setMeretGB(int $meretGB): void
    {
        $this->meretGB = $meretGB;
    }




}