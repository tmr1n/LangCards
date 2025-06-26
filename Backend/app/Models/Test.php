<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasTableColumns;
    protected $table = 'tests';
    protected $guarded = [];

    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class, 'deck_id');
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Questions::class, 'test_id');
    }
    public function userTestResults(): HasMany
    {
        return $this->hasMany(UserTestResult::class, 'test_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
