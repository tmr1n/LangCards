<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'questions';
    protected $guarded = [];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'question_id');
    }
    public function userTestAnswers(): HasMany
    {
        return $this->hasMany(UserTestAnswer::class, 'question_id');
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
            new ColumnLabel('text', 'Текст вопроса'),
            new ColumnLabel('type', 'Тип вопроса'),
            new ColumnLabel('card_id', 'Карточка'),
            new ColumnLabel('test_id', 'Тест'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
