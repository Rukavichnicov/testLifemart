<?php

declare(strict_types=1);

namespace App\Services;

class BuildDishesService
{
    public function __construct(private UniqueCombinationsService $uniqueCombinationsService)
    {
    }

    public function createArrayUniqueDishesByCodes(
        array $allIngredients,
        array $countIngredientsByCode,
        string $stringIngredientCodes
    ): array {
        $arrayUniqueIngredientsByCodes = $this->getArrayUniqueIngredientsByCodes($allIngredients, $countIngredientsByCode);
        $arrayRequestIngredientCodes = mb_str_split($stringIngredientCodes);
        $countUniqueDishes = array_product(array_map(fn($ingredients) => count($ingredients), $arrayUniqueIngredientsByCodes));
        $orderCodes = array_fill_keys($arrayRequestIngredientCodes, 0);
        $arrayUniqueDishesByCodes = [];
        for ($i = 1; $i <= $countUniqueDishes; ++$i) {
            $price = 0;
            $currentCombination = [];
            foreach ($arrayRequestIngredientCodes as $code) {
                $countUniqueIngredientsByCode = count($arrayUniqueIngredientsByCodes[$code]);
                $keyUniqueIngredient = $this->getKeyUniqueIngredient($i, $countUniqueIngredientsByCode);
                $orderIngredient = $orderCodes[$code]++;
                $currentCombination[] = [
                    'type' => $arrayUniqueIngredientsByCodes[$code][$keyUniqueIngredient][$orderIngredient]['type'],
                    'value' => $arrayUniqueIngredientsByCodes[$code][$keyUniqueIngredient][$orderIngredient]['value'],
                ];
                $price += $arrayUniqueIngredientsByCodes[$code][$keyUniqueIngredient][$orderIngredient]['price'];
            }
            $currentCombination['price'] = $price;
            $arrayUniqueDishesByCodes[] = $currentCombination;

            $orderCodes = array_fill_keys($arrayRequestIngredientCodes, 0);
        }

        return $arrayUniqueDishesByCodes;
    }

    private function getArrayUniqueIngredientsByCodes(array $allIngredients, array $countIngredientsByCode): array
    {
        $arrayUniqueIngredientsByCodes = [];
        $allIngredientsByCodes = [];
        foreach ($allIngredients as $ingredient) {
            $allIngredientsByCodes[$ingredient['code']][] = [
                'type' => $ingredient['type'],
                'value' => $ingredient['value'],
                'price' => $ingredient['price'],
            ];
        }
        foreach ($allIngredientsByCodes as $code => $ingredients) {
            $arrayUniqueIngredientsByCodes[$code] = $this->uniqueCombinationsService->createUniqueCombination(
                $ingredients,
                $countIngredientsByCode[$code]
            );
        }
        return $arrayUniqueIngredientsByCodes;
    }

    private function getKeyUniqueIngredient(int $i, int $countUniqueIngredientsByCode): int
    {

        if ($i > $countUniqueIngredientsByCode) {
            $keyUniqueIngredient = $countUniqueIngredientsByCode % $i;
            if ($keyUniqueIngredient === 0) {
                $keyUniqueIngredient = $countUniqueIngredientsByCode - 1;
            } else {
                $keyUniqueIngredient--;
            }
        } else {
            $keyUniqueIngredient = $i - 1;
        }
        return $keyUniqueIngredient;
    }
}

