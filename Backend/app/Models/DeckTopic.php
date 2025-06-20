<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeckTopic extends Model
{
    protected $table = 'deck_topics';
    protected $guarded = [];
    protected function casts(): array
    {
        return [

        ];
    }
}
