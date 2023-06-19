<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            "uuid" => $this->uuid,
            "slug" => $this->slug,
            "task" => $this->task,
            "description" => $this->description,
            "is_completed" => $this->is_completed,
            "user" => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
