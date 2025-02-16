<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'path' => $this->path,
            'type' => $this->type,
            'size' => $this->size,
            'isFree' => $this->isFree,
            'owner' => new UserResource($this->owner),
            'checked_by' => $this->checked_by ? new UserResource($this->checkedBy) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
