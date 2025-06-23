<?php

namespace App\Services;

use App\Repositories\CurrencyRepositories\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    protected CurrencyRepositoryInterface $currencyRepository;
    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }
    public function getCurrencyByIp(string $ip)
    {
        $ipAddressService = new IpAddressService();
        $apiKey = config('services.ipgeolocation.key');
        $response = Http::get("https://api.ipgeolocation.io/v2/ipgeo", [
            'apiKey' => $apiKey,
            'ip' => $ipAddressService->getIpAddress($ip),
            'fields'=>'currency'
        ]);
        $data = $response->json();
        $currencyId = null;
        if (isset($data['currency'])) {
            if(!$this->currencyRepository->isExistByCode($data['currency']['code'])) {
                $this->currencyRepository->saveNewCurrency($data['currency']['name'], $data['currency']['code'], $data['currency']['symbol']);
            }
            $currencyInfoFromDatabase = $this->currencyRepository->getByCode($data['currency']['code']);
            $currencyId = $currencyInfoFromDatabase->id;
        }
        return $currencyId;
    }
}
