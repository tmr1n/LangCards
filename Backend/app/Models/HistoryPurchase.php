<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPurchase extends Model
{
    protected $table = 'history_purchases';
    protected $guarded = [];
    public function cost(): BelongsTo
    {
        return $this->belongsTo(Cost::class, 'cost_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
