<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TypeInfoAboutDeck;
use App\Http\Controllers\Controller;
use App\Http\Filters\FiltersForModels\DeckFilter;
use App\Http\Resources\v1\DeckResources\DeckResource;
use App\Http\Responses\ApiResponse;
use App\Models\UserTestResult;
use App\Repositories\DeckRepositories\DeckRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use App\Services\PaginatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeckController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    protected DeckRepositoryInterface $deckRepository;

    protected UserTestResultRepositoryInterface $userTestResultRepository;

    public function __construct(DeckRepositoryInterface $deckRepository, UserTestResultRepositoryInterface $userTestResultRepository, UserRepositoryInterface $userRepository)
    {
        $this->deckRepository = $deckRepository;
        $this->userTestResultRepository = $userTestResultRepository;
        $this->userRepository = $userRepository;
    }

    public function getDecks(Request $request, PaginatorService $paginator, DeckFilter $deckFilter)
    {
        $countOnPage = (int)$request->input('countOnPage', config('app.default_count_on_page'));
        $numberCurrentPage = (int)$request->input('page', config('app.default_page'));
        $data = $this->deckRepository->getDecksWithPaginationAndFilters($paginator,$deckFilter, $countOnPage, $numberCurrentPage);
        return ApiResponse::success("Данные о колодах на странице $numberCurrentPage", (object)['items'=>DeckResource::collection($data['items']),
            'pagination' => $data['pagination']]);
    }
    public function deleteDeck(int $id)
    {
        $userId = auth()->id();
        $currentDeck = $this->deckRepository->getDeckById($id, TypeInfoAboutDeck::minimum);
        if($currentDeck === null)
        {
            return ApiResponse::error("Колода с id = $id не найдена", null, 404);
        }
        if($currentDeck->user_id !== $userId)
        {
            return ApiResponse::error("Текущий авторизованный пользователь не является автором колоды, поэтому не имеет права на её удаление", null, 403);
        }
        $hasAnyStartedTests =$this->userTestResultRepository->existStartedTestForDeck($id);
        if($hasAnyStartedTests === false)
        {
            $this->deckRepository->deleteDeckById($id);
            return ApiResponse::success("Колода с id = $id была успешно удалена навсегда");
        }
        $this->deckRepository->softDeleteDeckById($id);
        return ApiResponse::success("Колода с id = $id была успешно мягко удалена");
    }
    public function getDeck(int $id)
    {
        $deck = $this->deckRepository->getDeckById($id,TypeInfoAboutDeck::maximum);
        if($deck === null)
        {
            return ApiResponse::error("Колода с id = $id не найдена", null, 404);
        }
        if($deck->is_premium && !$this->userRepository->hasUserActivePremiumStatusByIdUser(auth()->id()))
        {
            return ApiResponse::error("Колода с id = $id является премиальной. Её просмотр для пользователей с неактивным премиум-статусом невозможен", null, 403);
        }
        return ApiResponse::success("Колода с id = $id найдена", (object)['item'=>new DeckResource($deck)]);
    }
}
