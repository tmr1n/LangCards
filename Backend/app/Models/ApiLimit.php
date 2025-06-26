<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class ApiLimit extends Model implements  ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'api_limits';
    protected $guarded = [];

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id','Идентификатор'),
            new ColumnLabel('day','Дата (день)'),
            new ColumnLabel('request_count','Количество запросов'),
            new ColumnLabel('created_at','Дата создания записи'),
            new ColumnLabel('updated_at','Дата обновления записи'),
        ];
    }
}
