<?php

namespace App\Repositories\TestRepositories;

interface TestRepositoryInterface
{
    public function isExistRepositoryById(int $id): bool;
    public function saveNewTest(string $name, ?int $timeSeconds, ?int $countAttempts, int $deckId);
}
