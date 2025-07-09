<?php

namespace App\Repositories\UserTestAnswerRepositories;

interface UserTestAnswerRepositoryInterface
{
    public function saveNewUserTestAnswer(int $user_test_result_id, int $question_id, int $answer_id, bool $is_correct): void;
}
