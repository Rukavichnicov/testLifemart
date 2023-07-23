<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private int $type_id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column]
    private int $price;

    public function getId(): int
    {
        return $this->id;
    }
}
