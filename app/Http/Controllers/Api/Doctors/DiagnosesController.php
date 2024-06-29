<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\DiagnoseStoreRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Doctors\DiagnoseUpdateRequest;
use App\Http\Resources\DiagnoseResource;
use App\Models\Diagnose;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;

class DiagnosesController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_diagnoses,doctor')->only('index', 'show');
        $this->middleware('permission:create_diagnoses,doctor')->only('store');
        $this->middleware('permission:update_diagnoses,doctor')->only('update');
        $this->middleware('permission:delete_diagnoses,doctor')->only('destroy');
        $this->middleware('permission:delete_diagnoses,doctor')->only('deleteMany');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $diagnoses = Diagnose::paginate();

        $paginationData = $this->getPaginationData($diagnoses);

        return $this->sendResponse(
            DiagnoseResource::collection($diagnoses),
            'diagnoses sent successfully',
            $paginationData
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiagnoseStoreRequest $request): JsonResponse
    {
        $diagnose = Diagnose::create($request->validated());

        return $this->sendResponse(
            new DiagnoseResource($diagnose),
            'diagnose created successfully',
            [],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $diagnose = Diagnose::find($id);

        if (!$diagnose) {
            return $this->sendError('diagnose not found');
        }

        return $this->sendResponse(new DiagnoseResource($diagnose), 'diagnose sent successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiagnoseUpdateRequest $request, string $id): JsonResponse
    {
        $diagnose = Diagnose::find($id);

        if (!$diagnose) {
            return $this->sendError('diagnose not found');
        }

        $diagnose->update($request->validated());

        return $this->sendResponse(new DiagnoseResource($diagnose), 'diagnose updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $diagnose = Diagnose::find($id);

        if (!$diagnose) {
            return $this->sendError('diagnose not found');
        }

        $diagnose->delete();
        return $this->sendResponse(new DiagnoseResource($diagnose), 'diagnose deleted successfully');
    }

    public function deleteMany(Request $request): JsonResponse
    {
        $diagnoses = Diagnose::find($request->input('ids'));
        $status = Diagnose::destroy($request->input('ids'));
        if (!$status)
            return $this->sendError('diagnoses not found');

        return $this->sendResponse(DiagnoseResource::collection($diagnoses), 'diagnoses deleted successfully');
    }
}
