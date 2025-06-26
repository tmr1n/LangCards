<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cost extends Model implements  ColumnLabelsableInterface
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

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id', 'Идентификатор'),
            new ColumnLabel('cost', 'Стоимость'),
            new ColumnLabel('currency_id', 'Валюта'),
            new ColumnLabel('tariff_id', 'Тариф'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
