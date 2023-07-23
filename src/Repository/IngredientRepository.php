<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\IngredientType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function findAllByCodes(array $codes): array
    {
        $qb = $this->createQueryBuilder('ing')
            ->select('ing_t.title as type', 'ing.title as value', 'ing.price', 'ing_t.code')
            ->leftJoin(IngredientType::class, 'ing_t', 'WITH', 'ing.type_id = ing_t.id')
            ->where('ing_t.code IN (:codes)')
            ->setParameter('codes', $codes);

        $query = $qb->getQuery();

        return $query->execute();
    }
}