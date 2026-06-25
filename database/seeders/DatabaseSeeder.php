<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\LeadStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@minicrm.test'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'role'     => UserRole::Admin,
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@minicrm.test'],
            [
                'name'     => 'Standard User',
                'password' => Hash::make('password'),
                'role'     => UserRole::User,
            ]
        );

        $leads = [
            [
                'name'        => 'James Carter',
                'email'       => 'james.carter@example.com',
                'phone'       => '+1-202-555-0191',
                'status'      => LeadStatus::New,
                'assigned_to' => $user->id,
                'created_by'  => $admin->id,
                'notes' => [
                    ['user_id' => $admin->id, 'note' => 'Initial contact made via website form. Interested in enterprise plan.'],
                    ['user_id' => $user->id,  'note' => 'Sent product brochure and pricing sheet over email.'],
                ],
            ],
            [
                'name'        => 'Sophia Martinez',
                'email'       => 'sophia.martinez@techcorp.io',
                'phone'       => '+1-415-555-0172',
                'status'      => LeadStatus::Contacted,
                'assigned_to' => $user->id,
                'created_by'  => $admin->id,
                'notes' => [
                    ['user_id' => $user->id,  'note' => 'Had a 30-minute discovery call. She is evaluating 3 vendors.'],
                    ['user_id' => $user->id,  'note' => 'Follow-up scheduled for next Monday. Needs approval from her manager.'],
                    ['user_id' => $admin->id, 'note' => 'Offering a 15% discount if they sign before end of month.'],
                ],
            ],
            [
                'name'        => 'David Kim',
                'email'       => 'david.kim@startup.co',
                'phone'       => '+1-312-555-0148',
                'status'      => LeadStatus::Converted,
                'assigned_to' => $user->id,
                'created_by'  => $admin->id,
                'notes' => [
                    ['user_id' => $user->id,  'note' => 'Very interested from the first call. Budget already approved.'],
                    ['user_id' => $user->id,  'note' => 'Sent contract for review. Legal team is going through it.'],
                    ['user_id' => $admin->id, 'note' => 'Contract signed. Onboarding scheduled for next week. Great win!'],
                ],
            ],
            [
                'name'        => 'Emily Johnson',
                'email'       => 'emily.j@globalretail.com',
                'phone'       => '+1-646-555-0103',
                'status'      => LeadStatus::New,
                'assigned_to' => null,
                'created_by'  => $admin->id,
                'notes' => [
                    ['user_id' => $admin->id, 'note' => 'Came in through LinkedIn ad. Requested a demo for next week.'],
                ],
            ],
        ];

        foreach ($leads as $leadData) {
            $notes = $leadData['notes'];
            unset($leadData['notes']);

            $lead = Lead::create($leadData);

            foreach ($notes as $i => $note) {
                LeadNote::create([
                    'lead_id'    => $lead->id,
                    'user_id'    => $note['user_id'],
                    'note'       => $note['note'],
                    'created_at' => now()->addMinutes($i * 30),
                ]);
            }
        }
    }
}
