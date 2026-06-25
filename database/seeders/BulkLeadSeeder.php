<?php

namespace Database\Seeders;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class BulkLeadSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@minicrm.test')->firstOrFail();
        $user  = User::where('email', 'user@minicrm.test')->firstOrFail();

        $leads = [
            ['name' => 'Liam Anderson',    'email' => 'liam.anderson@nexustech.com',     'phone' => '+1-503-555-0121', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'Olivia Brown',     'email' => 'olivia.brown@brightmedia.io',     'phone' => '+1-617-555-0134', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Noah Williams',    'email' => 'noah.w@alphalogistics.net',        'phone' => '+1-214-555-0177', 'status' => LeadStatus::Converted,  'assigned_to' => $user->id],
            ['name' => 'Emma Jones',       'email' => 'emma.jones@vertexsolutions.com',   'phone' => '+1-713-555-0188', 'status' => LeadStatus::New,       'assigned_to' => null],
            ['name' => 'William Davis',    'email' => 'william.davis@cloudpeak.io',       'phone' => '+1-312-555-0145', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Ava Miller',       'email' => 'ava.miller@horizonretail.com',     'phone' => '+1-404-555-0162', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'James Wilson',     'email' => 'james.wilson@summitgroup.co',      'phone' => '+1-206-555-0193', 'status' => LeadStatus::Converted,  'assigned_to' => null],
            ['name' => 'Isabella Moore',   'email' => 'isabella.m@prismanalytics.com',    'phone' => '+1-602-555-0116', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Oliver Taylor',    'email' => 'oliver.t@blueridgefinance.com',    'phone' => '+1-702-555-0129', 'status' => LeadStatus::New,       'assigned_to' => null],
            ['name' => 'Sophia Thomas',    'email' => 'sophia.t@zenithcorp.net',          'phone' => '+1-512-555-0154', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'Benjamin Jackson', 'email' => 'ben.jackson@aurorainc.com',        'phone' => '+1-303-555-0167', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Mia White',        'email' => 'mia.white@cascadedigital.io',      'phone' => '+1-801-555-0180', 'status' => LeadStatus::Converted,  'assigned_to' => $user->id],
            ['name' => 'Elijah Harris',    'email' => 'elijah.h@pinnacleventures.com',    'phone' => '+1-615-555-0112', 'status' => LeadStatus::New,       'assigned_to' => null],
            ['name' => 'Charlotte Martin', 'email' => 'charlotte.m@meridiangroup.com',    'phone' => '+1-919-555-0141', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Lucas Thompson',   'email' => 'lucas.t@polarstarsystems.net',     'phone' => '+1-480-555-0158', 'status' => LeadStatus::Converted,  'assigned_to' => $user->id],
            ['name' => 'Amelia Garcia',    'email' => 'amelia.g@crestlinetech.com',       'phone' => '+1-720-555-0173', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'Mason Martinez',   'email' => 'mason.m@harborwave.io',            'phone' => '+1-954-555-0186', 'status' => LeadStatus::Contacted,  'assigned_to' => null],
            ['name' => 'Harper Robinson',  'email' => 'harper.r@ironwoodconsulting.com',  'phone' => '+1-571-555-0119', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'Ethan Clark',      'email' => 'ethan.c@solsticemarketing.com',    'phone' => '+1-469-555-0132', 'status' => LeadStatus::Converted,  'assigned_to' => $user->id],
            ['name' => 'Evelyn Rodriguez', 'email' => 'evelyn.r@apexbuilders.net',        'phone' => '+1-253-555-0147', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Alexander Lewis',  'email' => 'alex.l@northstarenterprise.com',   'phone' => '+1-347-555-0163', 'status' => LeadStatus::New,       'assigned_to' => null],
            ['name' => 'Abigail Lee',      'email' => 'abigail.l@sterlingsolutions.io',   'phone' => '+1-816-555-0176', 'status' => LeadStatus::Converted,  'assigned_to' => $user->id],
            ['name' => 'Michael Walker',   'email' => 'michael.w@cobaltventures.com',     'phone' => '+1-561-555-0189', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Emily Hall',       'email' => 'emily.h@vanguarddigital.net',      'phone' => '+1-773-555-0122', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'Daniel Allen',     'email' => 'daniel.a@tidewatersystems.com',    'phone' => '+1-630-555-0135', 'status' => LeadStatus::Converted,  'assigned_to' => null],
            ['name' => 'Sofia Young',      'email' => 'sofia.y@crescentlabs.io',          'phone' => '+1-907-555-0148', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Matthew Hernandez','email' => 'matt.h@keystonegroup.com',         'phone' => '+1-228-555-0161', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
            ['name' => 'Scarlett King',    'email' => 'scarlett.k@fulcrumtech.net',       'phone' => '+1-352-555-0174', 'status' => LeadStatus::Contacted,  'assigned_to' => $user->id],
            ['name' => 'Henry Wright',     'email' => 'henry.w@silverlakecorp.com',       'phone' => '+1-239-555-0187', 'status' => LeadStatus::Converted,  'assigned_to' => null],
            ['name' => 'Luna Scott',       'email' => 'luna.s@tridentinnovations.io',     'phone' => '+1-518-555-0110', 'status' => LeadStatus::New,       'assigned_to' => $user->id],
        ];

        $notes = [
            LeadStatus::New->value       => 'Initial enquiry received. Will follow up within 48 hours.',
            LeadStatus::Contacted->value => 'Had an introductory call. Prospect is evaluating options and will get back to us.',
            LeadStatus::Converted->value => 'Deal closed successfully. Onboarding kicked off.',
        ];

        foreach ($leads as $i => $leadData) {
            $lead = Lead::create([
                ...$leadData,
                'created_by' => $admin->id,
            ]);

            LeadNote::create([
                'lead_id'    => $lead->id,
                'user_id'    => $leadData['assigned_to'] ?? $admin->id,
                'note'       => $notes[$leadData['status']->value],
                'created_at' => now()->subDays(30 - $i),
            ]);
        }
    }
}
