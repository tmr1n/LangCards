<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model implements  ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'cards';
    protected $guarded = [];

    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class, 'deck_id');
    }
    public function examples(): HasMany
    {
        return $this->hasMany(Example::class, 'card_id');
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'card_id');
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
            new ColumnLabel('word', 'Слово'),
            new ColumnLabel('translate', 'Перевод'),
            new ColumnLabel('image_url', 'Ссылка на изображение'),
            new ColumnLabel('pronunciation_url', 'Ссылка на произношение'),
            new ColumnLabel('deck_id', 'Колода'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
