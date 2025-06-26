<?php

namespace App\Models;

use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTestResult extends Model implements ColumnLabelsableInterface
{
    use HasTableColumns;
    protected $table = 'user_test_results';
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
    public function userTestAnswers(): HasMany
    {
        return $this->hasMany(UserTestAnswer::class, 'user_test_result_id');
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
            new ColumnLabel('score', 'Баллы'),
            new ColumnLabel('start_time', 'Время начала'),
            new ColumnLabel('finish_time', 'Время завершения'),
            new ColumnLabel('user_id', 'Пользователь'),
            new ColumnLabel('test_id', 'Тест'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
