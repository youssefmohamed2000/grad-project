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

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            return $this->sendError('Auth failed', ['These credentials don\'t match our records']);
        }

        $token = $user->createToken('user-access-token')->plainTextToken;

        $data = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return $this->sendResponse($data, 'User Logged in Successfully');
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
