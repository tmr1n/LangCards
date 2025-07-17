<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'tariffs';
    protected $guarded = [];

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, 'tariff_id');
    }
    public function promocodes(): HasMany
    {
        return $this->hasMany(Tariff::class, 'tariff_id');
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
            new ColumnLabel('name','Название тарифа'),
            new ColumnLabel('days','Продолжительность (дней)'),
            new ColumnLabel('is_active','Активен'),
            new ColumnLabel('created_at','Дата создания'),
            new ColumnLabel('updated_at','Дата обновления')
        ];
    }
}
