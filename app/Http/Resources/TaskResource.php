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
            'id'          => $this->resource->id,
            'title'       => $this->resource->name,
            'description' => $this->resource->description,
            'image'       => $this->resource->image,
            'status'      => $this->resource->status,
            'user_id'     => $this->resource->user_id,
            'created_at'  => $this->resource->created_at,
            'updated_at'  => $this->resource->updated_at,
            'deleted_at'  => $this->resource->deleted_at,
        ];
    }
}
