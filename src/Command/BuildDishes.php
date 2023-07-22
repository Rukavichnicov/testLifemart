<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:build-dishes')]
class BuildDishes extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('ingredientСodes', InputArgument::REQUIRED, 'Строка, содержащая коды ингредиентов')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $output->writeln('Username: ' . $input->getArgument('ingredientСodes'));
        return Command::SUCCESS;
    }
}

