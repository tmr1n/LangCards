<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class DeckTopic extends Model
{
    use HasTableColumns;
    protected $table = 'deck_topics';
    protected $guarded = [];
    protected function casts(): array
    {
        return [

        ];
    }
}
