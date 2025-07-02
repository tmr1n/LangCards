<?php

namespace App\Repositories\CardRepositories;

use App\Models\Card;

class CardRepository implements CardRepositoryInterface
{

    protected Card $model;

    public function __construct(Card $model)
    {
        $this->model = $model;
    }

    public function isExistCardByDeckIdAndWord($deckId, $word): bool
    {
        return $this->model->where('deck_id', '=', $deckId)->where('word', '=', $word)->exists();
    }

    public function saveNewCard(string $word, string $translate, ?string $image_url, ?string $pronunciation_url, $deckId)
    {
        $newCard = new Card();
        $newCard->word = $word;
        $newCard->translate = $translate;
        $newCard->image_url = $image_url;
        $newCard->pronunciation_url = $pronunciation_url;
        $newCard->deck_id = $deckId;
        $newCard->save();
    }

    public function isExistCardById(int $idCard): bool
    {
        return $this->model->where('id', '=', $idCard)->exists();
    }

    public function getCardById(int $idCard): ?Card
    {
        return $this->model->where('id', '=', $idCard)->first();
    }
}
