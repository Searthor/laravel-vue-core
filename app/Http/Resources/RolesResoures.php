<?php

namespace App\Http\Resources;

use App\Models\FunctionAvailable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesResoures extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "des" => $this->des,
            'function_id' => FunctionAvailable::where('role_id', $this->id)
                ->pluck('function_id')->toArray(),

            // Corrected Parents_id query
            'Parents_id' => FunctionAvailable::where('role_id', $this->id)
                ->join('function_models', 'function_availables.function_id', '=', 'function_models.id') // Correct the join condition
                ->whereNull('function_models.parent_id') // Correct condition to check for null parent_id
                ->pluck('function_models.id')->toArray(),
        ];
    }
}
