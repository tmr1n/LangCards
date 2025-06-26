<?php

namespace App\Models;

use App\Traits\HasTableColumns;
use Illuminate\Database\Eloquent\Model;

class ApiLimit extends Model
{
    use HasTableColumns;
    protected $table = 'api_limits';
    protected $guarded = [];
}
