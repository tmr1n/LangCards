<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTestAnswer extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'user_test_answers';
    protected $guarded = [];

    public function questionAnswer(): BelongsTo
    {
        return $this->belongsTo(QuestionAnswer::class, 'answer_id');
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function userTestResult(): BelongsTo
    {
        return $this->belongsTo(UserTestResult::class, 'user_test_result_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id', 'Идентификатор'),
            new ColumnLabel('user_test_result_id', 'Результат теста пользователя'),
            new ColumnLabel('question_id', 'Вопрос'),
            new ColumnLabel('answer_id', 'Ответ'),
            new ColumnLabel('is_correct', 'Правильный ответ'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
