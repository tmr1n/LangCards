<?php

namespace App\Repositories\DeckRepositories;

interface DeckRepositoryInterface
{
    public function saveNewDeck(string $name, int $originalLanguageId, int $targetLanguageId, int $userId, bool $isPremium);
}
