<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\DoctorStoreRequest;
use App\Http\Requests\Api\Doctors\DoctorUpdateRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\UserResource;
use App\Models\Doctor;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $doctors = Doctor::paginate(15);

        $paginationData = $this->getPaginationData($doctors);

        return $this->sendResponse(DoctorResource::collection($doctors), 'doctors sent successfully', $paginationData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request): JsonResponse
    {
        $data = $this->prepareDoctorData($request);

        $doctor = Doctor::create($data);

        return $this->sendResponse(new DoctorResource($doctor), 'doctor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if(!$doctor){
            return $this->sendError('doctor not found');
        }
        return $this->sendResponse(new DoctorResource($doctor), 'doctor sent successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if(!$doctor){
            return $this->sendError('doctor not found');
        }

        $data = $this->prepareDoctorData($request);

        $doctor->update($data);

        return $this->sendResponse(new DoctorResource($doctor), 'doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);

        if(!$doctor){
            return $this->sendError('doctor not found');
        }

        $doctor->delete();
        return $this->sendResponse(new DoctorResource($doctor), 'doctor deleted successfully');
    }

    private function prepareDoctorData(Request $request): array
    {
        return $request->safe()->merge([
            'password' => Hash::make($request->validated('password')),
        ])->toArray();
    }
}
