<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Users\LoginRequest;
use App\Http\Requests\Api\Users\RegisterRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->validated('email');
        $password = $request->validated('password');

        if (!Auth::guard('user')->attempt(['email' => $email, 'password' => $password])) {
            return $this->sendError('Auth failed', ['this credentials don\'t match our records']);
        }

        $user = Auth::guard('user')->user();
        $token = $user->createToken('user-access-token')->plainTextToken;

        $data = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return $this->sendResponse($data, 'User Logged in Successfully');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->safe()->merge([
            'password' => Hash::make($request->validated('password')),
        ]);

        $user = User::query()->create($credentials->toArray());
        $token = $user->createToken('user-access-token')->plainTextToken;

        $data = [
            'doctor' => new UserResource($user),
            'token' => $token
        ];

        return $this->sendResponse($data, 'User Registered Successfully');
    }

    public function currentUser(): JsonResponse
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return $this->sendError('Failed To Get User');
        }

        return $this->sendResponse(new UserResource($user), 'User Sent');
    }

    public function logout(): JsonResponse
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return $this->sendError('Failed To Get User');
        }

        $user->currentAccessToken()->delete();

        return $this->sendResponse(message: 'User Logged out Successfully');
    }
}
