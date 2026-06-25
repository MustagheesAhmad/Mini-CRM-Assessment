<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    /**
     * Admins bypass all policy checks automatically via the `before` hook.
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Lead $lead): bool
    {
        return (int) $lead->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Lead $lead): bool
    {
        return (int) $lead->assigned_to === $user->id;
    }

    public function delete(User $user, Lead $lead): bool
    {
        return false;
    }

    public function restore(User $user, Lead $lead): bool
    {
        return false;
    }

    public function forceDelete(User $user, Lead $lead): bool
    {
        return false;
    }

    public function assign(User $user, Lead $lead): bool
    {
        return false;
    }

    public function updateStatus(User $user, Lead $lead): bool
    {
        return (int) $lead->assigned_to === $user->id;
    }

    public function addNote(User $user, Lead $lead): bool
    {
        return (int) $lead->assigned_to === $user->id;
    }
}
