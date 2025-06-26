<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionAnswer extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'question_answers';
    protected $guarded = [];
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function userTestAnswers(): HasMany
    {
        return $this->hasMany(UserTestAnswer::class, 'answer_id');
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
            new ColumnLabel('text_answer', 'Текст ответа'),
            new ColumnLabel('question_id', 'Вопрос'),
            new ColumnLabel('is_correct', 'Правильный ответ'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
