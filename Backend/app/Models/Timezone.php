<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timezone extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;

    protected $table = 'timezones';
    protected $guarded = [];
    protected $fillable = ['name', 'offset_utc'];


    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'timezone_id');
    }

    public static function columnLabels(): array
    {
         return [
             new ColumnLabel('id', 'Идентификатор'),
             new ColumnLabel('name', 'Название часового пояса'),
             new ColumnLabel('offset_utc', 'Смещение UTC'),
             new ColumnLabel('created_at', 'Дата создания'),
             new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
