<?php

namespace App\Http\Controllers\Api\Doctors;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_roles,doctor')->only('index');
        $this->middleware('permission:create_roles,doctor')->only('store');
        $this->middleware('permission:update_roles,doctor')->only('update');
        $this->middleware('permission:delete_roles,doctor')->only('delete');
    }

    public function index(): JsonResponse
    {
        $permissions = Permission::all();

        return $this->sendResponse(
            PermissionResource::collection($permissions),
            'permissions sent successfully'
        );
    }
}
