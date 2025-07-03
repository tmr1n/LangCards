<?php

namespace App\Repositories\QuestionAnswerRepository;

interface QuestionAnswerRepositoryInterface
{
    public function isExistAnswerForQuestionByTextAnswer(string $textAnswer, int $questionId): bool;
    public function saveNewAnswer(string $answer, int $questionId, bool $isCorrect);
}
