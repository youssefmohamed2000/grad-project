<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function index(): JsonResponse
    {
        $permissions = Permission::all();

        return $this->sendResponse(
            PermissionResource::collection($permissions),
            'permissions sent successfully'
        );
    }
}
