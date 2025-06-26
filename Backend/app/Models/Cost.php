<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cost extends Model
{
    use HasTableColumns;
    protected $table = 'costs';
    protected $guarded = [];
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function historyPurchases()
    {
        return $this->hasMany(HistoryPurchase::class, 'cost_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
