<?php

namespace App\Repositories\UserTestResultRepositories;

use App\Models\UserTestResult;

class UserTestResultRepository implements UserTestResultRepositoryInterface
{
    protected UserTestResult $model;
    public function __construct(UserTestResult $model)
    {
        $this->model = $model;
    }

    public function saveNewUserTestResult(string $startTime, int $userId, int $testId, ?string $end_time=null, ?int $score = null): void
    {
        $newUserTestResult = new UserTestResult();
        $newUserTestResult->start_time = $startTime;
        $newUserTestResult->user_id = $userId;
        $newUserTestResult->test_id = $testId;
        $newUserTestResult->score = $score;
        $newUserTestResult->finish_time = $end_time;
        $newUserTestResult->save();
    }

    public function updateUserTestResultAfterEnding(string $endTime, int $score, int $userTestResultId): void
    {
        $this->model->where('id','=', $userTestResultId)
            ->update(['end_time' => $endTime, 'score' => $score]);
    }

    public function getCountAttemptsOfTestByUserId($testId, $userId): int
    {
        return $this->model->where('test_id','=',$testId)->where('user_id','=',$userId)->count();
    }
}
