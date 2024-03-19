<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplainResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'complain' => $this->complain,
            'start date' => $this->start_date,
            'increase with' => $this->increase_with,
            'decrease with' => $this->decrease_with,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
