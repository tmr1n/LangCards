<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class VisitedDeck extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'visited_decks';
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
            new ColumnLabel('deck_id', 'Колода'),
            new ColumnLabel('user_id', 'Пользователь'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
