<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\RoleStoreRequest;
use App\Http\Requests\Api\Doctors\RoleUpdateRequest;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_roles,doctor')->only('index');
        $this->middleware('permission:create_roles,doctor')->only('store');
        $this->middleware('permission:update_roles,doctor')->only('update');
        $this->middleware('permission:delete_roles,doctor')->only('delete');
    }

    public function index(): JsonResponse
    {
        $roles = Role::paginate(15);

        $paginationData = $this->getPaginationData($roles);

        return $this->sendResponse(
            RoleResource::collection($roles),
            'roles sent successfully',
            $paginationData
        );
    }

    public function store(RoleStoreRequest $request): JsonResponse
    {
        $role = Role::create([
            'guard_name' => 'doctor',
            'name' => $request->validated('name')
        ]);

        $role->syncPermissions($request->validated('permissions'));

        return $this->sendResponse(new RoleResource($role), 'role created successfully');
    }

    public function update(RoleUpdateRequest $request, string $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return $this->sendError('role not found');
        }

        $role->update([
            'name' => $request->validated('name')
        ]);

        $role->syncPermissions($request->validated('permissions'));

        return $this->sendResponse(new RoleResource($role), 'role updated successfully');
    }

    public function destroy(string $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return $this->sendError('role not found');
        }

        $role->delete();

        return $this->sendResponse(new RoleResource($role), 'role deleted successfully');
    }
}
