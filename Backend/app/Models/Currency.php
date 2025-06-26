<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model implements  ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'currencies';
    protected $guarded = [];

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, 'currency_id');
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'currency_id');
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
            new ColumnLabel('name', 'Название валюты'),
            new ColumnLabel('code', 'Код валюты (ISO 4217)'),
            new ColumnLabel('symbol', 'Символ валюты'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
