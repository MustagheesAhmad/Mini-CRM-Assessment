<?php

namespace App\Services;

use App\Enums\LeadStatus;
use App\Jobs\LeadConvertedJob;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LeadService
{
    public function list(User $user, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Lead::with(['assignee', 'creator'])
            ->withCount('notes');

        if (! $user->isAdmin()) {
            $query->where('assigned_to', $user->id);
        }

        $query->filterByStatus($filters['status'] ?? null)
              ->filterByAssignee($filters['assigned_to'] ?? null);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function create(array $data, User $creator): Lead
    {
        $data['created_by'] = $creator->id;
        $data['status']     = $data['status'] ?? LeadStatus::New->value;

        return Lead::create($data);
    }

    public function find(int $id): Lead
    {
        return Lead::with(['assignee', 'creator', 'notes.author'])->findOrFail($id);
    }

    public function update(Lead $lead, array $data): Lead
    {
        $lead->update($data);

        return $lead->fresh(['assignee', 'creator']);
    }

    public function delete(Lead $lead): void
    {
        $lead->delete();
    }

public function assign(Lead $lead, int $userId): Lead
    {
        $lead->update(['assigned_to' => $userId]);

        return $lead->fresh(['assignee', 'creator']);
    }

    public function updateStatus(Lead $lead, LeadStatus $status, User $actor): Lead
    {
        $previousStatus = $lead->status;

        $lead->update(['status' => $status->value]);

        if ($status === LeadStatus::Converted && $previousStatus !== LeadStatus::Converted) {
            LeadConvertedJob::dispatch($lead->fresh(), $actor);
        }

        return $lead->fresh(['assignee', 'creator']);
    }
}
