<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionAnswer extends Model
{
    protected $table = 'question_answers';
    protected $guarded = [];
    public function question(): BelongsTo
    {
        return $this->belongsTo(Questions::class, 'question_id');
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
}
