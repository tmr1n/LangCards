<?php

namespace App\Repositories\UserTestResultRepositories;

use App\Models\UserTestResult;

interface UserTestResultRepositoryInterface
{


    public function saveNewUserTestResult(string $startTime, int $userId, int $testId, ?string $end_time=null, ?int $score = null);

    public function updateUserTestResultAfterEnding(string $endTime, int $score, int $userTestResultId);

    public function getCountAttemptsOfTestByUserId($testId, $userId): int;

    public function getUserTestResultById(int $id): ?UserTestResult;
}
