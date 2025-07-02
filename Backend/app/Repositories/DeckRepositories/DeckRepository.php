<?php

namespace App\Repositories\DeckRepositories;

use App\Models\Deck;

class DeckRepository implements DeckRepositoryInterface
{
    protected Deck $model;
    public function __construct(Deck $model)
    {
        $this->model = $model;
    }

    public function saveNewDeck(string $name, int $originalLanguageId, int $targetLanguageId, int $userId, bool $isPremium): void
    {
        $newDeck = new Deck();
        $newDeck->name = $name;
        $newDeck->original_language_id = $originalLanguageId;
        $newDeck->target_language_id = $targetLanguageId;
        $newDeck->user_id = $userId;
        $newDeck->is_premium = $isPremium;
        $newDeck->save();
    }

    public function isExistDeckById(int $id): bool
    {
        return $this->model->where('id','=', $id)->exists();
    }
}
