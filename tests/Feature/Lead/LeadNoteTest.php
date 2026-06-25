<?php

namespace Tests\Feature\Lead;

use App\Enums\UserRole;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadNoteTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $standardUser;
    private Lead $lead;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => UserRole::Admin]);
        $this->standardUser = User::factory()->create(['role' => UserRole::User]);

        $this->lead = Lead::factory()->create([
            'created_by'  => $this->admin->id,
            'assigned_to' => $this->standardUser->id,
        ]);
    }

    public function test_assigned_user_can_add_note_to_lead(): void
    {
        $this->actingAs($this->standardUser)
            ->postJson("/api/leads/{$this->lead->id}/notes", [
                'note' => 'Spoke to client on the phone.',
            ])
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.note', 'Spoke to client on the phone.');

        $this->assertDatabaseHas('lead_notes', [
            'lead_id' => $this->lead->id,
            'user_id' => $this->standardUser->id,
        ]);
    }

    public function test_unassigned_user_cannot_add_note(): void
    {
        $anotherUser = User::factory()->create(['role' => UserRole::User]);

        $this->actingAs($anotherUser)
            ->postJson("/api/leads/{$this->lead->id}/notes", [
                'note' => 'Trying to add a note',
            ])
            ->assertForbidden();
    }

    public function test_note_content_is_required(): void
    {
        $this->actingAs($this->standardUser)
            ->postJson("/api/leads/{$this->lead->id}/notes", [])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['note']]);
    }

    public function test_notes_are_listed_in_chronological_order(): void
    {
        $this->lead->notes()->create([
            'user_id'    => $this->standardUser->id,
            'note'       => 'First note',
            'created_at' => now()->subMinutes(10),
        ]);

        $this->lead->notes()->create([
            'user_id'    => $this->standardUser->id,
            'note'       => 'Second note',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson("/api/leads/{$this->lead->id}/notes");

        $response->assertOk();
        $notes = $response->json('data');
        $this->assertEquals('First note', $notes[0]['note']);
        $this->assertEquals('Second note', $notes[1]['note']);
    }

    public function test_admin_can_list_notes_for_any_lead(): void
    {
        $this->lead->notes()->create([
            'user_id'    => $this->standardUser->id,
            'note'       => 'A note',
            'created_at' => now(),
        ]);

        $this->actingAs($this->admin)
            ->getJson("/api/leads/{$this->lead->id}/notes")
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_note_tracks_its_author(): void
    {
        $response = $this->actingAs($this->standardUser)
            ->postJson("/api/leads/{$this->lead->id}/notes", [
                'note' => 'Test author tracking',
            ]);

        $response->assertCreated();
        $this->assertEquals($this->standardUser->name, $response->json('data.author.name'));
    }
}
