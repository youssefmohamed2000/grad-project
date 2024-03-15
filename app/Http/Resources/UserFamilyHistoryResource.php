<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFamilyHistoryResource extends JsonResource
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
            'parents_relative' => $this->parents_relative == 1 ? 'Yes' : 'No',
            'parents_same_complain' => $this->parents_same_complain == 1 ? 'Yes' : 'No',
            'genetic_diseases' => $this->genetic_diseases,
        ];
    }
}
