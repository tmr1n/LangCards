<?php

namespace App\Repositories\TestRepositories;

use App\Models\Test;

class TestRepository implements TestRepositoryInterface
{
    protected Test $model;

    public function __construct(Test $model)
    {
        $this->model = $model;
    }

    public function isExistRepositoryById(int $id): bool
    {
        return $this->model->where('id', '=', $id)->exists();
    }

    public function saveNewTest(string $name, ?int $timeSeconds, ?int $countAttempts, int $deckId)
    {
        $newTest = new Test();
        $newTest->name = $name;
        $newTest->time_seconds = $timeSeconds;
        $newTest->count_attempts = $countAttempts;
        $newTest->deck_id = $deckId;
        $newTest->save();
    }
}
