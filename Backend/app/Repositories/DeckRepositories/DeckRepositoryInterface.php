<?php

namespace App\Repositories\DeckRepositories;

use App\Models\Deck;

interface DeckRepositoryInterface
{
    public function isExistDeckById(int $id): bool;

    public function saveNewDeck(string $name, int $originalLanguageId, int $targetLanguageId, int $userId, bool $isPremium);
}
