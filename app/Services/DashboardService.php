<?php

namespace App\Services;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\User;

class DashboardService
{
    public function stats(User $user): array
    {
        $query = Lead::query();

        if (! $user->isAdmin()) {
            $query->where('assigned_to', $user->id);
        }

        $counts = (clone $query)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return [
            'total'     => $counts->sum(),
            'new'       => $counts->get(LeadStatus::New->value, 0),
            'contacted' => $counts->get(LeadStatus::Contacted->value, 0),
            'converted' => $counts->get(LeadStatus::Converted->value, 0),
        ];
    }
}
