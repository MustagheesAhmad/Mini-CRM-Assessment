<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'status'      => $this->status->value,
            'status_label'=> $this->status->label(),
            'assigned_to' => $this->whenLoaded('assignee', fn () => $this->assignee ? (new UserResource($this->assignee))->resolve() : null),
            'created_by'  => $this->whenLoaded('creator', fn () => (new UserResource($this->creator))->resolve()),
            'notes_count' => $this->when(isset($this->notes_count), $this->notes_count),
            'notes'       => $this->whenLoaded('notes', fn () => LeadNoteResource::collection($this->notes)->resolve()),
            'created_at'  => $this->created_at?->toISOString(),
            'updated_at'  => $this->updated_at?->toISOString(),
            'deleted_at'  => $this->deleted_at?->toISOString(),
        ];
    }
}
