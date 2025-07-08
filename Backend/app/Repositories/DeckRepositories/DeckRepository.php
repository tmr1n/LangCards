<?php

namespace App\Repositories\DeckRepositories;

use App\Http\Filters\FiltersForModels\DeckFilter;
use App\Models\Deck;
use App\Services\PaginatorService;

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

    public function getDecksWithPaginationAndFilters(PaginatorService $paginator, DeckFilter $deckFilter, int $countOnPage, int $numberCurrentPage): array
    {
        $query = $this->model->with(['originalLanguage', 'targetLanguage','user', 'topics'])->withCount(['visitors', 'tests', 'cards'])->filter($deckFilter);
        $data = $paginator->paginate($query, $countOnPage, $numberCurrentPage);
        $metadataPagination = $paginator->getMetadataForPagination($data);
        return ['items' => collect($data->items()), "pagination" => $metadataPagination];
    }
}
