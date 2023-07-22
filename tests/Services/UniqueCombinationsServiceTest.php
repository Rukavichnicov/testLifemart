<?php

declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\UniqueCombinationsService;
use PHPUnit\Framework\TestCase;

class UniqueCombinationsServiceTest extends TestCase
{
    private static $service;

    public static function setUpBeforeClass(): void
    {
        self::$service = new UniqueCombinationsService();
    }
    public function testHandleSimpleArrayLengthOne()
    {
        $listElements = ['А', 'Б', 'В', 'Г'];
        $lengthOneCombination = 1;
        $simpleCombination = self::$service->createUniqueCombination($listElements, $lengthOneCombination);

        $this->assertEquals([['А'], ['Б'], ['В'], ['Г']], $simpleCombination);
    }

    public function testHandleSimpleArrayLengthTwo()
    {
        $listElements = ['А', 'Б', 'В', 'Г'];
        $lengthOneCombination = 2;
        $simpleCombination = self::$service->createUniqueCombination($listElements, $lengthOneCombination);

        $this->assertEquals([['А', 'Б'], ['А', 'В'], ['А', 'Г'], ['Б', 'В'], ['Б', 'Г'], ['В', 'Г']], $simpleCombination);
    }

    public function testHandleSimpleArrayLengthThree()
    {
        $listElements = ['А', 'Б', 'В', 'Г'];
        $lengthOneCombination = 3;
        $simpleCombination = self::$service->createUniqueCombination($listElements, $lengthOneCombination);

        $this->assertEquals([
            ['А', 'Б', 'В'],
            ['А', 'Б', 'Г'],
            ['А', 'В', 'Г'],
            ['Б', 'В', 'Г'],
        ], $simpleCombination);
    }

    public function testHandleSimpleArrayLengthFour()
    {
        $listElements = ['А', 'Б', 'В', 'Г'];
        $lengthOneCombination = 4;
        $simpleCombination = self::$service->createUniqueCombination($listElements, $lengthOneCombination);

        $this->assertEquals([
            ['А', 'Б', 'В', 'Г'],
        ], $simpleCombination);
    }
}
