<?php

namespace App\Repositories\CardRepositories;

use App\Models\Card;

interface CardRepositoryInterface
{
    public function isExistCardById(int $idCard): bool;
    public function isExistCardByDeckIdAndWord($deckId, $word);

    public function getCardById(int $idCard): ?Card;
    public function saveNewCard(string $word, string $translate, ?string $image_url, ?string $pronunciation_url, $deckId);
}
