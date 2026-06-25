<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadNoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'note'       => $this->note,
            'author'     => $this->whenLoaded('author', fn () => (new UserResource($this->author))->resolve()),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
