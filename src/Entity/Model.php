<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="model")
 */
class Model implements \JsonSerializable
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
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $modelName;

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
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName(string $modelName): void
    {
        $this->modelName = $modelName;
    }

    public function jsonSerialize()
    {
        return ["id" => $this->id, "modelName" => $this->modelName];
    }
}