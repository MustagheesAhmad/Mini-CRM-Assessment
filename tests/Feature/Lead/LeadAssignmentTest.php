<?php

namespace Tests\Feature\Lead;

use App\Enums\LeadStatus;
use App\Enums\UserRole;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\LeadConvertedJob;
use Tests\TestCase;

class LeadAssignmentTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $standardUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => UserRole::Admin]);
        $this->standardUser = User::factory()->create(['role' => UserRole::User]);
    }

    public function test_admin_can_assign_lead_to_user(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->patchJson("/api/leads/{$lead->id}/assign", [
                'assigned_to' => $this->standardUser->id,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('leads', [
            'id'          => $lead->id,
            'assigned_to' => $this->standardUser->id,
        ]);
    }

    public function test_standard_user_cannot_assign_leads(): void
    {
        $lead = Lead::factory()->create([
            'created_by'  => $this->admin->id,
            'assigned_to' => $this->standardUser->id,
        ]);

        $anotherUser = User::factory()->create(['role' => UserRole::User]);

        $this->actingAs($this->standardUser)
            ->patchJson("/api/leads/{$lead->id}/assign", [
                'assigned_to' => $anotherUser->id,
            ])
            ->assertForbidden();
    }

    public function test_assign_fails_for_nonexistent_user(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->patchJson("/api/leads/{$lead->id}/assign", [
                'assigned_to' => 99999,
            ])
            ->assertStatus(422);
    }

    public function test_admin_can_update_lead_status(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->patchJson("/api/leads/{$lead->id}/status", [
                'status' => LeadStatus::Contacted->value,
            ])
            ->assertOk()
            ->assertJsonPath('data.status', 'contacted');
    }

    public function test_converting_lead_dispatches_queue_job(): void
    {
        Queue::fake();

        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->patchJson("/api/leads/{$lead->id}/status", [
                'status' => LeadStatus::Converted->value,
            ])
            ->assertOk();

        Queue::assertPushed(LeadConvertedJob::class);
    }

    public function test_converting_already_converted_lead_does_not_dispatch_job(): void
    {
        Queue::fake();

        $lead = Lead::factory()->create([
            'created_by' => $this->admin->id,
            'status'     => LeadStatus::Converted->value,
        ]);

        $this->actingAs($this->admin)
            ->patchJson("/api/leads/{$lead->id}/status", [
                'status' => LeadStatus::Converted->value,
            ])
            ->assertOk();

        Queue::assertNotPushed(LeadConvertedJob::class);
    }

    public function test_status_update_rejects_invalid_status(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->patchJson("/api/leads/{$lead->id}/status", [
                'status' => 'bogus_status',
            ])
            ->assertStatus(422);
    }
}
