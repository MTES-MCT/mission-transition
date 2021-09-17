<?php

namespace App\Entity\Util;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait EntityIdTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list"})
     */
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
