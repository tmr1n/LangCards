<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examples extends Model
{
    protected $table = 'examples';
    protected $guarded = [];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
