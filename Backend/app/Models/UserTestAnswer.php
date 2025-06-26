<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTestAnswer extends Model
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
        return $this->belongsTo(Questions::class, 'question_id');
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
}
