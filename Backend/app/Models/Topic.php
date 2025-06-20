<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topic extends Model
{
    protected $table = 'topics';
    protected $guarded = [];
    public function decks(): BelongsToMany
    {
        return $this->belongsToMany(Deck::class, 'deck_topics', 'topic_id', 'deck_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
