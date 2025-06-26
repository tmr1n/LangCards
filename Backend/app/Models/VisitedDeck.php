<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class VisitedDeck extends Model
{
    use HasTableColumns;
    protected $table = 'visited_decks';
    protected $guarded = [];
    protected function casts(): array
    {
        return [

        ];
    }
}
