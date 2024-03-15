<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\UserDetailsRequest;
use App\Http\Resources\UserDetailsResource;
use App\Models\UserDetail;

class UserDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_users,doctor')->only('show');
        $this->middleware('permission:create_users,doctor')->only('storeOrUpdate');
        $this->middleware('permission:update_users,doctor')->only('storeOrUpdate');
    }

    public function storeOrUpdate(UserDetailsRequest $request): JsonResponse
    {
        $userDetails = UserDetail::updateOrCreate(
            ['user_id' => $request->validated('user_id')],
            $request->validated()
        );

        $user = User::find($userDetails->user_id);
        $user->chronicDiseases()->sync($request->validated('chronic_diseases'));

        return $this->sendResponse(
            new UserDetailsResource($userDetails),
            'user details created successfully',
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

        $userDetails = $user->details;

        if ($userDetails) {
            return $this->sendResponse(new UserDetailsResource($userDetails), 'user details sent successfully');
        } else {
            return $this->sendResponse(message: 'user has no details');
        }
    }
}
