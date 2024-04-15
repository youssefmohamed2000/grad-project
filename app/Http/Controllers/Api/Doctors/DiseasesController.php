<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Traits\Helper;
use App\Models\ChronicDiseases;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChronicDiseasesResource;
use App\Http\Requests\Api\Doctors\ChronicDiseasesStoreRequest;
use App\Http\Requests\Api\Doctors\ChronicDiseasesUpdateRequest;

class DiseasesController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_diseases,doctor')->only('index');
        $this->middleware('permission:create_diseases,doctor')->only('store');
        $this->middleware('permission:update_diseases,doctor')->only('update');
        $this->middleware('permission:delete_diseases,doctor')->only('delete');
    }

    public function index(): JsonResponse
    {
        $diseases = ChronicDiseases::paginate(15);

        $paginationData = $this->getPaginationData($diseases);

        return $this->sendResponse(
            ChronicDiseasesResource::collection($diseases),
            'diseases sent successfully',
            $paginationData
        );
    }

    public function store(ChronicDiseasesStoreRequest $request): JsonResponse
    {
        $disease = ChronicDiseases::create($request->validated());

        return $this->sendResponse(
            new ChronicDiseasesResource($disease),
            'disease created successfully',
            [],
            201
        );
    }

    public function update(ChronicDiseasesUpdateRequest $request, string $id): JsonResponse
    {
        $disease = ChronicDiseases::find($id);

        if (!$disease) {
            return $this->sendError('diseases not found');
        }

        $disease->update($request->validated());

        return $this->sendResponse(
            new ChronicDiseasesResource($disease),
            'disease updated successfully',
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $disease = ChronicDiseases::find($id);

        if (!$disease) {
            return $this->sendError('diseases not found');
        }

        $disease->delete();

        return $this->sendResponse(
            new ChronicDiseasesResource($disease),
            'disease deleted successfully',
        );
    }
}
