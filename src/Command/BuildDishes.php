<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Ingredient;
use App\Exception\ValidateException;
use App\Repository\IngredientRepository;
use App\Services\BuildDishesService;
use App\Services\FileManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:build-dishes')]
class BuildDishes extends Command
{
    /**
     * @var IngredientRepository
     */
    private EntityRepository $ingredientRepository;

    private BuildDishesService $buildDishesService;

    private FileManagerService $fileManagerService;

    public function __construct(EntityManagerInterface $entityManager, BuildDishesService $buildDishesService, FileManagerService $fileManagerService)
    {
        parent::__construct();
        $this->ingredientRepository = $entityManager->getRepository(Ingredient::class);
        $this->buildDishesService = $buildDishesService;
        $this->fileManagerService = $fileManagerService;
    }

    protected function configure(): void
    {
        $this->addArgument('ingredientCodes', InputArgument::REQUIRED, 'Строка, содержащая коды ингредиентов');
    }

    /**
     * @throws ValidateException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stringIngredientCodes = $input->getArgument('ingredientCodes');
        $arrayIngredientCodesWithCount = array_count_values(mb_str_split($stringIngredientCodes));

        $arrayIngredientCodes = array_keys($arrayIngredientCodesWithCount);
        $allIngredients = $this->ingredientRepository->findAllByCodes($arrayIngredientCodes);

        $this->validate($arrayIngredientCodesWithCount, $allIngredients);

        $arrayUniqueDishes = $this->buildDishesService->createArrayUniqueDishesByCodes(
            $allIngredients,
            $arrayIngredientCodesWithCount,
            $stringIngredientCodes
        );

        $this->fileManagerService->saveFile($arrayUniqueDishes);

        $output->writeln([
            'JSON файл успешно создан!',
        ]);

        return Command::SUCCESS;
    }

    /**
     * @throws ValidateException
     */
    private function validate(array $arrayIngredientCodesWithCount, array $allIngredients): void
    {
        $allIngredientsByCodes = [];
        foreach ($allIngredients as $ingredient) {
            if (!isset($allIngredientsByCodes[$ingredient['code']])) {
                $allIngredientsByCodes[$ingredient['code']] = 1;
            } else {
                ++$allIngredientsByCodes[$ingredient['code']];
            }
        }
        foreach ($arrayIngredientCodesWithCount as $ingredient => $count) {
            if (!array_key_exists($ingredient, $allIngredientsByCodes)) {
                throw new ValidateException('Один или несколько игридиентов отсутствуют в базе данных');
            }
            if ($count > $allIngredientsByCodes[$ingredient]) {
                throw new ValidateException('Один или несколько игридиентов указаны слишком много раз');
            }
        }
    }
}

