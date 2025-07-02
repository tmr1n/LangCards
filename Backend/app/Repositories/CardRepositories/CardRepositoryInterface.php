<?php

namespace App\Repositories\CardRepositories;

interface CardRepositoryInterface
{
    public function isExistCardByDeckIdAndWord($deckId, $word);
    public function saveNewCard(string $word, string $translate, ?string $image_url, ?string $pronunciation_url, $deckId);
}
