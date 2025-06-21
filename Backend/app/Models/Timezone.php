<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timezone extends Model
{
    protected $table = 'timezones';
    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'timezone_id');
    }
}
