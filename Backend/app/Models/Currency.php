<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $guarded = [];

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, 'currency_id');
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'currency_id');
    }
    protected function casts(): array
    {
        return [

        ];
    }
}
