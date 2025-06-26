<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPurchase extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
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

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id', 'Идентификатор'),
            new ColumnLabel('date_purchase', 'Дата покупки'),
            new ColumnLabel('date_end', 'Дата окончания'),
            new ColumnLabel('user_id', 'Пользователь'),
            new ColumnLabel('cost_id', 'Стоимость'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
