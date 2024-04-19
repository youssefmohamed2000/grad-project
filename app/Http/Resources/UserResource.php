<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'sex' => $this->sex,
            'birth_place' => $this->birth_place,
            'address' => $this->address,
            'job' => $this->job,
            'phone' => $this->phone,
            'social_status' => $this->social_status,
            'created_at' => $this->created_at?->toDateString()
        ];
    }
}
