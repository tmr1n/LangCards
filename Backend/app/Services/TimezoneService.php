<?php

namespace App\Services;

use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use Illuminate\Support\Facades\Http;

class TimezoneService
{
    protected TimezoneRepositoryInterface $timezoneRepository;
    public function __construct(TimezoneRepositoryInterface $timezoneRepository)
    {
        $this->timezoneRepository = $timezoneRepository;
    }

    public function getTimezoneByIpUser(string $ip)
    {
        $ipAddressService = new IpAddressService();
        $apiKey = config('services.ipgeolocation.key');
        $response = Http::get("https://api.ipgeolocation.io/v2/timezone", [
            'apiKey' => $apiKey,
            'ip' => $ipAddressService->getIpAddress($ip),
        ]);
        $data = $response->json();
        $timezoneId = null;
        $nameRegion = data_get($data, 'time_zone.name');
        if (isset($nameRegion)) {
            if ($this->timezoneRepository->isExistRepositoryByNameRegion($nameRegion)) {
                $timezoneDB = $this->timezoneRepository->getRepositoryByNameRegion($nameRegion);
                $timezoneId = $timezoneDB->id;
            }
        }
        return $timezoneId;
    }
}
