<?php

namespace App\Http\Controllers\Api\V1\AuthControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequests\AuthRequest;
use App\Http\Resources\v1\AuthResources\AuthUserResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\CurrencyRepositories\CurrencyRepositoryInterface;
use App\Repositories\LoginRepositories\LoginRepositoryInterface;
use App\Repositories\RegistrationRepositories\RegistrationRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use App\Services\CurrencyService;
use App\Services\TimezoneService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected LoginRepositoryInterface $loginRepository;
    protected TimezoneRepositoryInterface $timezoneRepository;
    protected RegistrationRepositoryInterface $registrationRepository;
    protected CurrencyRepositoryInterface $currencyRepository;
    private array $acceptedProviders = ['google'];
    public function __construct(LoginRepositoryInterface $loginRepository,
                                TimezoneRepositoryInterface $timezoneRepository,
                                RegistrationRepositoryInterface $registrationRepository,
                                 CurrencyRepositoryInterface $currencyRepository)
    {
        $this->loginRepository = $loginRepository;
        $this->timezoneRepository  = $timezoneRepository;
        $this->registrationRepository = $registrationRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function login(AuthRequest $request)
    {
        $user = $this->loginRepository->getUserByEmail($request->email);
        if($user->password === null || !Hash::check($request->password, $user->password))
        {
            return ApiResponse::error("Пользователь с заданным email - адресом и паролем не найден", null, 401);
        }
        return ApiResponse::success('Пользователь успешно авторизован',(object)[
            'user' => new AuthUserResource($user),
            'token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }
    public function redirect($provider)
    {
        if(!in_array($provider, $this->acceptedProviders)){
            return ApiResponse::error("Отсутствует поддержка провайдера: $provider", null, 401);
        }
        $url = Socialite::driver($provider)
            ->stateless()
            ->redirect()
            ->getTargetUrl();
        return ApiResponse::success('Получена ссылка для OAuth - авторизации через провайдера '.$provider, (object)['url'=>$url]);
    }

    public function handleCallback($provider, Request $request)
    {
        try {
            if($provider == 'google') {
                $googleUser = Socialite::driver($provider)->stateless()->user();
                $userDB = $this->loginRepository->getUserByEmail($googleUser->email);
                //-------------- вроде дописал, протестить
                if($userDB === null) // аккаунта пользователя по gmail - почте нет
                {
                    $timezoneService = new TimezoneService($this->timezoneRepository);
                    $timezoneId = $timezoneService->getTimezoneByIpUser($request->ip());
                    $currencyService = new CurrencyService($this->currencyRepository);
                    $currencyIdFromDatabase = $currencyService->getCurrencyByIp($request->ip());
                    $email = $googleUser->getEmail();
                    $nickname = $googleUser->getNickname();
                    if($nickname === null)
                    {
                        $nickname = explode('@', $googleUser->getEmail())[0];
                    }
                    $this->registrationRepository->registerUser($nickname, $email, null, $timezoneId, $currencyIdFromDatabase);
                    $user = $this->loginRepository->getUserByEmail($email);
                    return ApiResponse::success('Пользователь успешно авторизован',(object)[
                        'user' => new AuthUserResource($user),
                        'token' => $user->createToken('auth-token')->plainTextToken
                    ]);

                }
                //--------------
                else
                {
                    if($userDB->password === null) // уже был создан аккаунт по gmail - почте через google авторизацию
                    {
                        return ApiResponse::success('Пользователь успешно авторизован',(object)[
                            'user' => new AuthUserResource($userDB),
                            'token' => $userDB->createToken('auth-token')->plainTextToken
                        ]);
                    }
                    else // был создан аккаунт по gmail - почте с использованием пароля
                    {
                        return ApiResponse::error("Невозможна авторизация через gmail, так как эта почта использовалась для авторизации с паролем", null, 409);
                    }
                }
            }
            return ApiResponse::error("Отсутствует поддержка провайдера: $provider", null, 401);
        } catch (Exception $exception) {
            logger($exception->getMessage());
            return ApiResponse::error("Ошибка авторизации через $provider", null, 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success('Выход из аккаунта успешно совершён');
    }
}
