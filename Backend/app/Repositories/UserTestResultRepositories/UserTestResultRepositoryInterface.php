<?php

namespace App\Repositories\UserTestResultRepositories;

interface UserTestResultRepositoryInterface
{
    public function saveNewUserTestResult(string $startTime, int $userId, int $testId, ?string $end_time=null, ?int $score = null);

    public function updateUserTestResultAfterEnding(string $endTime, int $score, int $userTestResultId);

    public function getCountAttemptsOfTestByUserId($testId, $userId): int;
}
