<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitedDeck extends Model
{
    protected $table = 'visited_decks';
    protected $guarded = [];
    protected function casts(): array
    {
        return [

        ];
    }
}
