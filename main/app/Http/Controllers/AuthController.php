<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\AuthService;
use Illuminate\Support\MessageBag;

//Payloads
use App\DTOs\Payloads\UserPayload;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Transforms request to UserPayload.
     * @param Request $request
     * Creates the new user and saves it to the database.
     * @return (ApiResponse::error | ApiResponse::success)
     */
    public function createUser(Request $request)
    {
        try {
            $user = $this->authService->createUser($request->all());

            if ($user instanceof MessageBag) 
                throw new \Exception('Validation error');

            return ApiResponse::success('User Created Successfully', ['token' => $user->createToken("API TOKEN")->plainTextToken]);

        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $userPayload = new UserPayload($request->only(['email', 'password']));
            $result = $this->authService->loginUser($userPayload);

            if ($result instanceof MessageBag)
                throw new \Exception('Validation error');

            if (!$result) {
                throw new \Exception('Email and Password does not match');
            }

            return ApiResponse::success('User Logged In Successfully', $result);

        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function logoutUser(Request $request)
    {
        $this->authService->logoutUser($request->user());

        return ApiResponse::success('Logged out');
    }

    public function getUserInfo()
    {
        /** @var \App\Models\User $user */
        $user = $this->authService->getUserInfo();

        $user = $user->getInfo();

        return ApiResponse::success('User information retrieved successfully', ['user' => $user]);
    }
}
