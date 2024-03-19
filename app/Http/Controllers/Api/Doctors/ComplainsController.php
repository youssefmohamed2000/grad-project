<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\ComplainStoreRequest;
use App\Http\Requests\Api\Doctors\ComplainUpdateRequest;
use App\Http\Resources\ComplainResource;
use App\Models\Complain;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;

class ComplainsController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_complains,doctor')->only('index', 'show');
        $this->middleware('permission:create_complains,doctor')->only('store');
        $this->middleware('permission:update_complains,doctor')->only('update');
        $this->middleware('permission:delete_complains,doctor')->only('delete');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $complains = Complain::paginate();
        $paginationData = $this->getPaginationData($complains);

        return $this->sendResponse(
            ComplainResource::collection($complains),
            'complains sent successfully',
            $paginationData
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComplainStoreRequest $request): JsonResponse
    {
        $complain = Complain::create($request->validated());

        return $this->sendResponse(
            new ComplainResource($complain),
            'complain created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        $complain = Complain::find($id);
        if (!$complain){
            return $this->sendError('complain not found');
        }

        return $this->sendResponse(new ComplainResource($complain), 'complain sent successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComplainUpdateRequest $request, string $id) : JsonResponse
    {
        $complain = Complain::find($id);
        if (!$complain){
            return $this->sendError('complain not found');
        }

        $complain->update($request->validated());

        return $this->sendResponse(new ComplainResource($complain), 'complain updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        $complain = Complain::find($id);
        if (!$complain){
            return $this->sendError('complain not found');
        }

        $complain->delete();
        return $this->sendResponse(new ComplainResource($complain), 'complain deleted successfully');
    }
}
