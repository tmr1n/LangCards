<?php

namespace App\Repositories\UserTestAnswerRepositories;

use App\Models\UserTestAnswer;

class UserTestAnswerRepository implements UserTestAnswerRepositoryInterface
{
    protected UserTestAnswer $model;
    public function __construct(UserTestAnswer $model)
    {
        $this->model = $model;
    }

    public function isExistAnswerForAttempt(int $attemptId): bool
    {
        return $this->model->where('user_test_result_id', '=', $attemptId)->exists();
    }

    public function saveNewUserTestAnswer(int $user_test_result_id, int $question_id, int $answer_id, bool $is_correct): void
    {
        $newUserTestAnswer = new UserTestAnswer();
        $newUserTestAnswer->user_test_result_id=$user_test_result_id;
        $newUserTestAnswer->question_id = $question_id;
        $newUserTestAnswer->answer_id = $answer_id;
        $newUserTestAnswer->is_correct = $is_correct;
        $newUserTestAnswer->save();
    }
}
