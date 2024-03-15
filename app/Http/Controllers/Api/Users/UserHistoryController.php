<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FamilyHistory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserFamilyHistoryResource;
use App\Http\Requests\Api\Users\UserHistoryRequest;

class UserHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_users,doctor')->only('show');
        $this->middleware('permission:create_users,doctor')->only('storeOrUpdate');
        $this->middleware('permission:update_users,doctor')->only('storeOrUpdate');
    }

    public function storeOrUpdate(UserHistoryRequest $request): JsonResponse
    {
        $userFamilyHistory = FamilyHistory::updateOrCreate(
            ['user_id' => $request->validated('user_id')],
            $request->validated()
        );

        return $this->sendResponse(
            new UserFamilyHistoryResource($userFamilyHistory),
            'user family history created successfully',
            [],
            201
        );
    }

    public function show(string $user_id): JsonResponse
    {
        $user = User::find($user_id);

        if (!$user) {
            return $this->sendError('user not found');
        }

        $userFamilyHistory = $user->family;

        if ($userFamilyHistory) {
            return $this->sendResponse(new UserFamilyHistoryResource($userFamilyHistory), 'user family history sent successfully');
        } else {
            return $this->sendResponse(message: 'user has no family history');
        }
    }
}
