<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timezone extends Model
{
    use HasTableColumns;

    protected $table = 'timezones';
    protected $guarded = [];
    protected $fillable = ['name', 'offset_utc'];


    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'timezone_id');
    }
}
