<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'drugs' => $this->drugs,
            'blood_transfusion' => $this->blood_transfusion,
            'allergy' => $this->allergy,
            'children_no' => $this->children_no,
            'last_child_age' => $this->last_child_age,
            'booked_before' => $this->booked_before,
            'booked_reason' => $this->booked_reason,
            'booked_duration' => $this->booked_duration,
            'blood_type' => $this->blood_type,
            'chronic_disease' => ChronicDiseasesResource::collection($this->user->chronicDiseases),
        ];
    }
}
