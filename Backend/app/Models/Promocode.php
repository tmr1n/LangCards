<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promocode extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'promocodes';
    protected $guarded = [];

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id', 'Идентификатор'),
            new ColumnLabel('code', 'Код'),
            new ColumnLabel('active', 'Статус активации'),
            new ColumnLabel('tariff_id', 'Тариф'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
    protected function casts(): array
    {
        return [
            'active' => 'bool',
        ];
    }
}
