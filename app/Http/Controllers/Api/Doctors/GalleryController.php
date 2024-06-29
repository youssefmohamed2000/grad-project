<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Traits\Helper;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\Doctors\GalleryRequest;

class GalleryController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_gallery,doctor')->only('index', 'show');
        $this->middleware('permission:create_gallery,doctor')->only('store');
        $this->middleware('permission:update_gallery,doctor')->only('update');
        $this->middleware('permission:delete_gallery,doctor')->only('destroy');
        $this->middleware('permission:delete_gallery,doctor')->only('deleteMany');
    }

    public function index(): JsonResponse
    {
        $galleries = Gallery::paginate(15);

        $paginationData = $this->getPaginationData($galleries);

        return $this->sendResponse(GalleryResource::collection($galleries), 'gallery sent successfully', $paginationData);
    }

    public function store(GalleryRequest $request): JsonResponse
    {
        if ($request->hasFile('image')) {
            $request->file('image')->store('gallery', 'public');

            $image = $request->file('image')->hashName();
        }

        $gallery = Gallery::create([
            'image' => $image
        ]);

        return $this->sendResponse(new GalleryResource($gallery), 'image added successfully', [], 201);
    }

    public function show(string $id): JsonResponse
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return $this->sendError('image not found');
        }

        return $this->sendResponse(new GalleryResource($gallery), 'image sent successfully');
    }

    public function update(GalleryRequest $request, string $id): JsonResponse
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return $this->sendError('image not found');
        }

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::delete('public/gallery/' . $gallery->image);
            }

            $request->file('image')->store('gallery', 'public');

            $image = $request->file('image')->hashName();
        }

        $gallery->update([
            'image' => $image,
        ]);

        return $this->sendResponse(new GalleryResource($gallery), 'image updated successfully', [], 201);
    }

    public function destroy(string $id): JsonResponse
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return $this->sendError('gallery not found');
        }

        $gallery->delete();

        return $this->sendResponse(new GalleryResource($gallery), 'image deleted successfully');
    }

    public function deleteMany(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:galleries,id',
        ]);

        try {
            $galleries = Gallery::destroy($request->input('ids'));
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse(message: 'images deleted successfully');
    }
}
