<?php

declare(strict_types=1);

namespace App\Services;

class UniqueCombinationsService
{
    private array $combinations;
    private array $currentCombination;

    public function createUniqueCombination(array $listElements, $lengthOneCombination): array
    {
        $this->combinations = [];
        $this->currentCombination = [];

        $this->generateCombinations($listElements, $lengthOneCombination);

        // Удаляем повторяющиеся сочетания
        array_walk($this->combinations, fn(&$currentCombination) => sort($currentCombination));
        $serializedStringFromCombinations = array_unique(array_map('serialize', $this->combinations));
        return array_map('unserialize', $serializedStringFromCombinations);
    }

    private function generateCombinations(array $listElements, $lengthOneCombination, $startIndex = 0): void
    {
        if ($lengthOneCombination === 0) {
            $this->combinations[] = $this->currentCombination;
            return;
        }

        $countListElements = count($listElements);
        $countIterations = $countListElements - $lengthOneCombination;

        for ($i = $startIndex; $i <= $countIterations; $i++) {
            $this->currentCombination[] = $listElements[$i];

            $this->generateCombinations($listElements, $lengthOneCombination - 1, $i + 1);

            array_pop($this->currentCombination);
        }
    }
}

