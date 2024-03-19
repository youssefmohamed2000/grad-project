<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiagnoseResource extends JsonResource
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
            'complain' => new ComplainResource($this->complain),
            'doctor' => new DoctorResource($this->doctor),
            'diagnose' => $this->diagnose,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
