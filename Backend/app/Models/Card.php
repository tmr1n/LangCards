<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasTableColumns;
    protected $table = 'cards';
    protected $guarded = [];

    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class, 'deck_id');
    }
    public function examples(): HasMany
    {
        return $this->hasMany(Examples::class, 'card_id');
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Questions::class, 'card_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
