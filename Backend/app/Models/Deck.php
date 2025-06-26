<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deck extends Model
{
    use HasTableColumns;
    protected $table = 'decks';
    protected $guarded = [];

    // Связь с исходным языком
    public function originalLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'original_language_id');
    }

    // Связь с целевым языком
    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function visitors(): BelongsToMany
    {
        return $this->belongsToMany(Deck::class, 'visited_decks',  'deck_id', 'user_id');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Deck::class, 'deck_topics', 'deck_id', 'topic_id');
    }
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'deck_id');
    }
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'deck_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
