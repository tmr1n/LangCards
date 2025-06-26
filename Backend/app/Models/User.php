<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\ColumnLabel;
use App\Models\Interfaces\ColumnLabelsableInterface;
use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements ColumnLabelsableInterface
{
    protected $table = 'users';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasTableColumns;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type_user',
        'currency_id',
        'timezone_id',
        'vip_status_time_end'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function historyPurchases(): HasMany
    {
        return $this->hasMany(HistoryPurchase::class, 'user_id');
    }
    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class, 'user_id');
    }
    public function visitedDecks(): BelongsToMany
    {
        return $this->belongsToMany(Deck::class, 'visited_decks', 'user_id', 'deck_id');
    }

    public function userTestResults(): HasMany
    {
        return $this->hasMany(UserTestResult::class, 'user_id');
    }

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class, 'timezone_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'vip_status_time_end' => 'datetime'
        ];
    }

    public static function columnLabels(): array
    {
        return [
            new ColumnLabel('id', 'Идентификатор'),
            new ColumnLabel('name', 'Имя'),
            new ColumnLabel('email', 'Электронная почта'),
            new ColumnLabel('avatar_url', 'Аватар'),
            new ColumnLabel('email_verified_at', 'Дата подтверждения почты'),
            new ColumnLabel('password', 'Пароль'),
            new ColumnLabel('type_user', 'Тип пользователя'),
            new ColumnLabel('currency_id', 'Валюта'),
            new ColumnLabel('timezone_id', 'Часовой пояс'),
            new ColumnLabel('vip_status_time_end', 'Окончание VIP-статуса'),
            new ColumnLabel('remember_token', 'Токен запоминания'),
            new ColumnLabel('created_at', 'Дата создания'),
            new ColumnLabel('updated_at', 'Дата обновления'),
        ];
    }
}
