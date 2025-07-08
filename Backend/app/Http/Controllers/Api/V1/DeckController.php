<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\FiltersForModels\DeckFilter;
use App\Http\Resources\v1\DeckResources\DeckResource;
use App\Http\Responses\ApiResponse;
use App\Models\UserTestResult;
use App\Repositories\DeckRepositories\DeckRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    protected DeckRepositoryInterface $deckRepository;

    protected UserTestResultRepositoryInterface $userTestResultRepository;

    public function __construct(DeckRepositoryInterface $deckRepository, UserTestResultRepositoryInterface $userTestResultRepository)
    {
        $this->deckRepository = $deckRepository;
        $this->userTestResultRepository = $userTestResultRepository;
    }

    public function getDecks(Request $request, PaginatorService $paginator, DeckFilter $deckFilter)
    {
        $countOnPage = (int)$request->input('countOnPage', 15);
        $numberCurrentPage = (int)$request->input('page', 1);
        $data = $this->deckRepository->getDecksWithPaginationAndFilters($paginator,$deckFilter, $countOnPage, $numberCurrentPage);
        //return ApiResponse::success("Данные о колодах на странице $numberCurrentPage", (object)$data);

        return ApiResponse::success("Данные о колодах на странице $numberCurrentPage", (object)['items'=>DeckResource::collection($data['items']),
            'pagination' => $data['pagination']]);
    }
    public function deleteDeck(int $deckId)
    {
        $userId = auth()->id();
        $currentDeck = $this->deckRepository->getDeckById($deckId);
        if($currentDeck === null)
        {
            return ApiResponse::error("Колода с id = $deckId не найдена", null, 404);
        }
        if($currentDeck->user_id !== $userId)
        {
            return ApiResponse::error("Текущий авторизованный пользователь не является автором колоды, поэтому не имеет права на её удаление", null, 403);
        }
        $hasAnyStartedTests =$this->userTestResultRepository->existStartedTestForDeck($deckId);
        if($hasAnyStartedTests === false)
        {
            $this->deckRepository->deleteDeckById($deckId);
            return ApiResponse::success("Колода с id = $deckId была успешно удалена навсегда");
        }
        $this->deckRepository->softDeleteDeckById($deckId);
        return ApiResponse::success("Колода с id = $deckId была успешно мягко удалена");
    }
}
