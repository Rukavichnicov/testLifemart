<?php

declare(strict_types=1);

namespace App\Services;

class FileManagerService
{
    public function saveFile(
        array $arrayUniqueDishes,
    ): void {
        $jsonUniqueDishes = json_encode($arrayUniqueDishes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if (!file_exists('upload')) {
            mkdir('upload');
        }
        file_put_contents('upload/uniqueDishes.json', $jsonUniqueDishes);
    }
}