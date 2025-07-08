<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\FiltersForModels\DeckFilter;
use App\Http\Resources\v1\DeckResources\DeckResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\DeckRepositories\DeckRepositoryInterface;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    protected DeckRepositoryInterface $deckRepository;

    public function __construct(DeckRepositoryInterface $deckRepository)
    {
        $this->deckRepository = $deckRepository;
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
}
