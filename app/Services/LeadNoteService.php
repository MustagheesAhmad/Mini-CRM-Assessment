<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class LeadNoteService
{
    public function listForLead(Lead $lead): Collection
    {
        return $lead->notes()->with('author')->get();
    }

    public function addNote(Lead $lead, User $author, string $noteContent): LeadNote
    {
        return $lead->notes()->create([
            'user_id'    => $author->id,
            'note'       => $noteContent,
            'created_at' => now(),
        ]);
    }
}
