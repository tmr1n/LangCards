<?php

namespace App\Repositories\UserTestResultRepositories;

use App\Models\UserTestResult;

interface UserTestResultRepositoryInterface
{

    public function existStartedTestForDeck(int $deckId): bool;
    public function saveNewUserTestResult(string $startTime, int $userId, int $testId, ?string $end_time=null, ?int $score = null): int;

    public function updateUserTestResultAfterEnding(string $endTime, int $score, int $userTestResultId);

    public function getCountAttemptsOfTestByUserId($testId, $userId): int;

    public function getUserTestResultById(int $id): ?UserTestResult;
}
