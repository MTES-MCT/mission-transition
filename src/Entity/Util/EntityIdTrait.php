<?php

namespace App\Entity\Util;

use Doctrine\ORM\Mapping as ORM;

trait EntityIdTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
