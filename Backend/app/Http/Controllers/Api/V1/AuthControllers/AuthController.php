<?php

namespace App\Http\Controllers\Api\V1\AuthControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequests\AuthRequest;
use App\Http\Resources\v1\AuthResources\AuthUserResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\LoginRepositories\LoginRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected LoginRepositoryInterface $loginRepository;
    public function __construct(LoginRepositoryInterface $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function login(AuthRequest $request)
    {
        $user = $this->loginRepository->getUserByEmail($request->email);
        if(!Hash::check($request->password, $user->password)){
            return ApiResponse::error("Пользователь с заданным email - адресом и паролем не найден", null, 401);
        }
        return ApiResponse::success('Пользователь успешно авторизован',(object)[
            'user' => new AuthUserResource($user),
            'token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }
}
