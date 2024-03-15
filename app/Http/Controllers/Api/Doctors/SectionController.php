<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Models\Section;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Requests\Api\Doctors\SectionStoreRequest;
use App\Http\Requests\Api\Doctors\SectionUpdateRequest;

class SectionController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_sections,doctor')->only('index');
        $this->middleware('permission:create_sections,doctor')->only('store');
        $this->middleware('permission:update_sections,doctor')->only('update');
        $this->middleware('permission:delete_sections,doctor')->only('delete');
    }

    public function index(): JsonResponse
    {
        $sections  = Section::paginate(15);

        $paginationData = $this->getPaginationData($sections);

        return $this->sendResponse(
            SectionResource::collection($sections),
            'sections sent successfully',
            $paginationData
        );
    }

    public function store(SectionStoreRequest $request): JsonResponse
    {
        $section = Section::create($request->validated());

        return $this->sendResponse(
            new SectionResource($section),
            'section created successfully',
        );
    }

    public function update(SectionUpdateRequest $request, string $id): JsonResponse
    {
        $section = Section::find($id);

        if (!$section) {
            return $this->sendError('section not found');
        }

        $section->update($request->validated());

        return $this->sendResponse(
            new SectionResource($section),
            'section updated successfully',
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $section = Section::find($id);

        if (!$section) {
            return $this->sendError('section not found');
        }

        $section->delete();

        return $this->sendResponse(
            new SectionResource($section),
            'section deleted successfully',
        );
    }
}
