<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
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
}
