<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\OperationStoreRequest;
use App\Http\Requests\Api\Doctors\OperationUpdateRequest;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;

class OperationsController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_operations,doctor')->only('index', 'show');
        $this->middleware('permission:create_operations,doctor')->only('store');
        $this->middleware('permission:update_operations,doctor')->only('update');
        $this->middleware('permission:delete_operations,doctor')->only('delete');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $operations = Operation::paginate();

        $paginationData = $this->getPaginationData($operations);

        return $this->sendResponse(
            OperationResource::collection($operations),
            'operations sent successfully',
            $paginationData
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperationStoreRequest $request) : JsonResponse
    {
        $operation = Operation::create($request->validated());

        return $this->sendResponse(
            new OperationResource($operation),
            'operation created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        $operation = Operation::find($id);
        if (!$operation){
            return $this->sendError('operation not found');
        }

        return $this->sendResponse(new OperationResource($operation), 'operation sent successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperationUpdateRequest $request, string $id) : JsonResponse
    {
        $operation = Operation::find($id);
        if (!$operation){
            return $this->sendError('operation not found');
        }

        $operation->update($request->validated());

        return $this->sendResponse(new OperationResource($operation), 'operation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        $operation = Operation::find($id);
        if (!$operation){
            return $this->sendError('operation not found');
        }

        $operation->delete();
        return $this->sendResponse(new OperationResource($operation), 'operation deleted successfully');
    }
}
