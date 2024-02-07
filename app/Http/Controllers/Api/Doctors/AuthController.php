<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Models\Doctor;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DoctorResource;
use App\Http\Requests\Api\Doctors\LoginRequest;
use App\Http\Requests\Api\Doctors\RegisterRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(LoginRequest $request): JsonResponse
    {
        $doctor = Doctor::where('email', $request->validated('email'))->first();

        if (!$doctor || !Hash::check($request->validated('password'), $doctor->password)) {
            return $this->sendError('Auth failed', ['These credentials don\'t match our records']);
        }

        $token = $doctor->createToken('doctor-access-token')->plainTextToken;

        $data = [
            'doctor' => new DoctorResource($doctor),
            'token' => $token
        ];

        return $this->sendResponse($data, 'Doctor Logged in Successfully');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->safe()->merge([
            'password' => Hash::make($request->validated('password')),
        ]);

        $doctor = Doctor::create($credentials->toArray());
        $token = $doctor->createToken('doctor-access-token')->plainTextToken;

        $data = [
            'user' => new DoctorResource($doctor),
            'token' => $token
        ];

        return $this->sendResponse($data, 'Doctor Registered Successfully');
    }

    public function currentDoctor(): JsonResponse
    {
        $doctor = auth('doctor')->user();

        if (!$doctor) {
            return $this->sendError('Failed To Get Doctor');
        }

        return $this->sendResponse(new DoctorResource($doctor), 'Doctor Sent');
    }

    public function logout(): JsonResponse
    {
        $doctor = auth('doctor')->user();

        if (!$doctor) {
            return $this->sendError('Failed To Get Doctor');
        }

        $doctor->currentAccessToken()->delete();

        return $this->sendResponse(message: 'Doctor Logged out Successfully');
    }
}
