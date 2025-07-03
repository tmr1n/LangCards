<?php

namespace App\Repositories\TestRepositories;

use App\Models\Test;

interface TestRepositoryInterface
{
    public function isExistTestById(int $id): bool;

    public function getTestById(int $id): Test;
    public function saveNewTest(string $name, ?int $timeSeconds, ?int $countAttempts, int $deckId);
}
