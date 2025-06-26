<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTestResult extends Model
{
    use HasTableColumns;
    protected $table = 'user_test_results';
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
    public function userTestAnswers(): HasMany
    {
        return $this->hasMany(UserTestAnswer::class, 'user_test_result_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
