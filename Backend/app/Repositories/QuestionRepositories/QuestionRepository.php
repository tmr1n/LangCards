<?php

namespace App\Repositories\QuestionRepositories;

use App\Models\Card;
use App\Models\Question;

class QuestionRepository implements QuestionRepositoryInterface
{

    public function isExistCardForQuestionInSameDeckAsTest(int $cardId, int $testId)
    {
        return Card::where('id', $cardId)
            ->whereHas('deck', function ($query1) use ($testId) {
                $query1->whereHas('tests', function ($query2) use ($testId) {
                    $query2->where('id', $testId);
                });
            })->exists();
    }

    public function saveNewQuestion(?string $text, string $type, int $cardId, int $testId)
    {
        $newQuestionForTest = new Question();
        $newQuestionForTest->text = $text;
        $newQuestionForTest->type = $type;
        $newQuestionForTest->card_id = $cardId;
        $newQuestionForTest->test_id = $testId;
        $newQuestionForTest->save();
    }
}
