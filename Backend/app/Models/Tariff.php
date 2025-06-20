<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model
{
    protected $table = 'tariffs';
    protected $guarded = [];

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, 'tariff_id');
    }

    protected function casts(): array
    {
        return [

        ];
    }
}
