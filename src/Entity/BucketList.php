<?php

namespace App\Entity;

use App\Repository\BucketListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BucketListRepository::class)]
class BucketList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
