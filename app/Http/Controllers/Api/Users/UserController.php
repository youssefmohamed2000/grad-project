<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Users\UserStoreRequest;
use App\Http\Requests\Api\Users\UserUpdateRequest;

class UserController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:create_users,doctor')->only('store');
        $this->middleware('permission:update_users,doctor')->only('update');
        $this->middleware('permission:delete_users,doctor')->only('destroy');
        $this->middleware('permission:delete_users,doctor')->only('deleteMany');
        if (auth('doctor')->check()) {
            $this->middleware('permission:read_users,doctor')->only('index', 'show');
        }
    }

    public function index(): JsonResponse
    {
        if (auth('user')->check())
            $users = User::where('id', auth('user')->user()->id)->paginate(15);
        else
            $users = User::paginate(15);

        $paginationData = $this->getPaginationData($users);

        return $this->sendResponse(UserResource::collection($users), 'users sent successfully', $paginationData);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->sendResponse(new UserResource($user), 'user created successfully', [], 201);
    }


    public function show(string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user)
            return $this->sendError('user not found');
        if (auth('user')->check())
            $this->authorize('view', $user);
        return $this->sendResponse(new UserResource($user), 'user sent successfully');
    }

    public function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('user not found');
        }

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

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

    public function deleteMany(Request $request): JsonResponse
    {
        $users = User::find($request->input('ids'));
        $status = User::destroy($request->input('ids'));
        if (!$status)
            return $this->sendError('users not found');
        return $this->sendResponse(UserResource::collection($users), 'users deleted successfully');
    }
}
