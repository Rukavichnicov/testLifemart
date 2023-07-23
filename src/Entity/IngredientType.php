<?php

namespace App\Entity;

use App\Repository\IngredientTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ingredient_type')]
#[ORM\Entity(repositoryClass: IngredientTypeRepository::class)]
class IngredientType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column]
    private ?string $code;

    public function getId(): int
    {
        return $this->id;
    }
}
