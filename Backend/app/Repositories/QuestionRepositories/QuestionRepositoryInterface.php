<?php

namespace App\Repositories\QuestionRepositories;

interface QuestionRepositoryInterface
{
    public function isExistCardForQuestionInSameDeckAsTest(int $cardId, int $testId);

    public function saveNewQuestion(?string $text, string $type, int $cardId, int $testId);
}
