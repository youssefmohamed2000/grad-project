<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Models\Doctor;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DoctorResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\Doctors\DoctorStoreRequest;
use App\Http\Requests\Api\Doctors\DoctorUpdateRequest;

class DoctorController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_doctors,doctor')->only('index', 'show');
        $this->middleware('permission:create_doctors,doctor')->only('store');
        $this->middleware('permission:update_doctors,doctor')->only('update');
        $this->middleware('permission:delete_doctors,doctor')->only('destroy');
        $this->middleware('permission:delete_doctors,doctor')->only('deleteMany');
    }

    public function index(): JsonResponse
    {
        $doctors = Doctor::paginate(15);

        $paginationData = $this->getPaginationData($doctors);

        return $this->sendResponse(DoctorResource::collection($doctors), 'doctors sent successfully', $paginationData);
    }

    public function store(DoctorStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('image')) {
            $request->file('image')->store('public/doctors');

            $data['image'] = $request->file('image')->hashName();
        }

        $doctor = Doctor::create($data);

        return $this->sendResponse(new DoctorResource($doctor), 'doctor created successfully', [], 201);
    }

    public function show(string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->sendError('doctor not found');
        }
        return $this->sendResponse(new DoctorResource($doctor), 'doctor sent successfully');
    }

    public function update(DoctorUpdateRequest $request, string $id): JsonResponse
    {
        $data = $request->all();

        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->sendError('doctor not found');
        }

        if ($request->hasFile('image')) {
            if ($doctor->image) {
                Storage::delete('public/doctors/' . $doctor->image);
            }

            $request->file('image')->store('public/doctors');

            $data  = array_merge(
                $data,
                [
                    'image' => $request->file('image')->hashName()
                ]
            );
        }

        $doctor->update($data);

        return $this->sendResponse(new DoctorResource($doctor), 'doctor updated successfully');
    }

    public function destroy(string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->sendError('doctor not found');
        }

        $doctor->delete();

        // if ($doctor->image) {
        //     Storage::delete('public/doctors/' . $doctor->image);
        // }

        return $this->sendResponse(new DoctorResource($doctor), 'doctor deleted successfully');
    }

    public function deleteMany(Request $request): JsonResponse
    {
        $doctors = Doctor::find($request->input('ids'));
        $status = Doctor::destroy($request->input('ids'));
        if (!$status)
            return $this->sendError('doctors not found');

        return $this->sendResponse(DoctorResource::collection($doctors), 'doctors deleted successfully');
    }
}
