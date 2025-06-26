<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'tests';
    protected $guarded = [];

    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class, 'deck_id');
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'test_id');
    }
    public function userTestResults(): HasMany
    {
        return $this->hasMany(UserTestResult::class, 'test_id');
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
            new ColumnLabel('name', 'Название теста'),
            new ColumnLabel('time_seconds', 'Время (секунды)'),
            new ColumnLabel('count_attempts', 'Количество попыток'),
            new ColumnLabel('deck_id', 'Колода'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
