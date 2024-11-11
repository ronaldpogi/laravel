<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'description' => $this->description,
            'is_desktop' => $this->is_desktop,
            'is_shared' => $this->is_shared,
            'is_web' => $this->is_web,
            'permissions' => $this->permissions ?? null
        ];
    }
}
