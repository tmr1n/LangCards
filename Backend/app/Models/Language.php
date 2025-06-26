<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class Language extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'languages';
    protected $guarded = [];

    public function originalLanguageDecks()
    {
        return $this->hasMany(Deck::class, 'original_language_id');
    }
    public function targetLanguageDecks()
    {
        return $this->hasMany(Deck::class, 'target_language_id');
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
            new ColumnLabel('name', 'Название языка'),
            new ColumnLabel('code', 'Код языка'),
            new ColumnLabel('flag_url', 'Ссылка на флаг'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
