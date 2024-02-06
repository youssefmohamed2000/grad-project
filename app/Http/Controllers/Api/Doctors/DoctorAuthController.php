<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\DoctorLoginRequest;
use App\Http\Requests\Api\Doctors\DoctorRegisterRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorAuthController extends Controller
{
    use ResponseTrait;

    public function login(DoctorLoginRequest $request): JsonResponse
    {
        $email = $request->validated('email');
        $password = $request->validated('password');

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return $this->sendError('Auth failed', 'this credentials don\'t match our records');
        }

        $doctor = Auth::guard('doctor')->user();
        $token = $doctor->createToken('doctor-access-token')->plainTextToken;

        $data = [
            'user' => new DoctorResource($doctor),
            'token' => $token
        ];

        return $this->sendResponse($data, 'User Logged in Successfully');
    }

    public function register(DoctorRegisterRequest $request): JsonResponse
    {
        $credentials = $request->safe()->merge([
            'password' => bcrypt($request->validated('password')),
        ]);

        $doctor = Doctor::create($credentials);
        $token = $doctor->createToken('doctor-access-token')->plainTextToken;

        $data = [
            'user' => new DoctorResource($doctor),
            'token' => $token
        ];

        return $this->sendResponse($data, 'User Registered Successfully');
    }

    public function currentDoctor(): JsonResponse
    {
        $doctor = auth('doctor')->user();

        if (!$doctor) {
            return $this->sendError('Failed To Get Doctor');
        }

        return $this->sendResponse(new DoctorResource($doctor), 'Doctor Sent');
    }

}
