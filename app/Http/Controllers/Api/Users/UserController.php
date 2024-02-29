<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Users\UserStoreRequest;
use App\Http\Requests\Api\Users\UserUpdateRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Helper;

    public function index(): JsonResponse
    {
        $users = User::paginate(15);

        $paginationData = $this->getPaginationData($users);

        return $this->sendResponse(UserResource::collection($users), 'users sent successfully', $paginationData);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $this->prepareUserData($request);

        $user = User::create($data);

        return $this->sendResponse(new UserResource($user), 'user created successfully');
    }

    public function show(string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('user not found');
        }
        return $this->sendResponse(new UserResource($user), 'user sent successfully');
    }

    public function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('user not found');
        }

        $data = $this->prepareUserData($request);

        $user->update($data);

        return $this->sendResponse(new UserResource($user), 'user updated successfully');
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('user not found');
        }

        $user->delete();

        return $this->sendResponse(new UserResource($user), 'user deleted successfully');
    }

    private function prepareUserData(Request $request): array
    {
        return $request->safe()->merge([
            'password' => Hash::make($request->validated('password')),
        ])->toArray();
    }
}
