<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class DeckTopic extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'deck_topics';
    protected $guarded = [];
    protected function casts(): array
    {
        return [

        ];
    }

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id', 'Идентификатор'),
            new ColumnLabel('topic_id', 'Тема'),
            new ColumnLabel('deck_id', 'Колода'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
