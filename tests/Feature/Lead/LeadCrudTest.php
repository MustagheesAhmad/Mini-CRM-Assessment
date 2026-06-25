<?php

namespace Tests\Feature\Lead;

use App\Enums\LeadStatus;
use App\Enums\UserRole;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadCrudTest extends TestCase
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

    public function test_admin_can_create_a_lead(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/api/leads', [
                'name'  => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1-555-1234',
            ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Jane Smith')
            ->assertJsonPath('data.status', LeadStatus::New->value);

        $this->assertDatabaseHas('leads', ['email' => 'jane@example.com']);
    }

    public function test_lead_creation_requires_name_email_phone(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/api/leads', []);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['name', 'email', 'phone']]);
    }

    public function test_lead_creation_rejects_invalid_status(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/api/leads', [
                'name'   => 'Test',
                'email'  => 'test@example.com',
                'phone'  => '555-0000',
                'status' => 'invalid_status',
            ]);

        $response->assertStatus(422);
    }

    public function test_admin_can_list_all_leads(): void
    {
        Lead::factory()->count(5)->create(['created_by' => $this->admin->id]);

        $response = $this->actingAs($this->admin)
            ->getJson('/api/leads');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['leads', 'pagination']]);
    }

    public function test_standard_user_sees_only_assigned_leads(): void
    {
        $assignedLead = Lead::factory()->create([
            'created_by'  => $this->admin->id,
            'assigned_to' => $this->standardUser->id,
        ]);

        Lead::factory()->create(['created_by' => $this->admin->id]);

        $response = $this->actingAs($this->standardUser)
            ->getJson('/api/leads');

        $response->assertOk();
        $leads = $response->json('data.leads');
        $this->assertCount(1, $leads);
        $this->assertEquals($assignedLead->id, $leads[0]['id']);
    }

    public function test_leads_can_be_filtered_by_status(): void
    {
        Lead::factory()->create(['created_by' => $this->admin->id, 'status' => LeadStatus::New->value]);
        Lead::factory()->create(['created_by' => $this->admin->id, 'status' => LeadStatus::Contacted->value]);

        $response = $this->actingAs($this->admin)
            ->getJson('/api/leads?status=new');

        $response->assertOk();
        $leads = $response->json('data.leads');
        $this->assertCount(1, $leads);
        $this->assertEquals('new', $leads[0]['status']);
    }

    public function test_admin_can_view_any_lead(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->getJson("/api/leads/{$lead->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $lead->id);
    }

    public function test_standard_user_cannot_view_unassigned_lead(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->standardUser)
            ->getJson("/api/leads/{$lead->id}")
            ->assertForbidden();
    }

    public function test_admin_can_update_any_lead(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->putJson("/api/leads/{$lead->id}", ['name' => 'Updated Name'])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Name');
    }

    public function test_admin_can_delete_a_lead(): void
    {
        $lead = Lead::factory()->create(['created_by' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->deleteJson("/api/leads/{$lead->id}")
            ->assertOk();

        $this->assertSoftDeleted('leads', ['id' => $lead->id]);
    }

    public function test_show_returns_404_for_nonexistent_lead(): void
    {
        $this->actingAs($this->admin)
            ->getJson('/api/leads/99999')
            ->assertNotFound();
    }
}
