<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\DoctorStoreRequest;
use App\Http\Requests\Api\Doctors\DoctorUpdateRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('permission:read_doctors,doctor')->only('index', 'show');
        $this->middleware('permission:create_doctors,doctor')->only('store');
        $this->middleware('permission:update_doctors,doctor')->only('update');
        $this->middleware('permission:delete_doctors,doctor')->only('delete');
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

        $doctor = Doctor::create($data);

        return $this->sendResponse(new DoctorResource($doctor), 'doctor created successfully', [] , 201);
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
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->sendError('doctor not found');
        }

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

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
        return $this->sendResponse(new DoctorResource($doctor), 'doctor deleted successfully');
    }
}
