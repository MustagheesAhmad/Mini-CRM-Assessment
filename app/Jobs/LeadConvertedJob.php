<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\LeadConversion;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LeadConvertedJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(
        private readonly Lead $lead,
        private readonly User $convertedBy,
    ) {}

    public function handle(): void
    {
        $convertedAt = now();

        LeadConversion::create([
            'lead_id'      => $this->lead->id,
            'lead_name'    => $this->lead->name,
            'converted_by' => $this->convertedBy->id,
            'converted_at' => $convertedAt,
            'created_at'   => $convertedAt,
        ]);

        Log::channel('stack')->info('Lead converted', [
            'lead_id'        => $this->lead->id,
            'lead_name'      => $this->lead->name,
            'converted_by'   => $this->convertedBy->name,
            'converted_at'   => $convertedAt->toISOString(),
        ]);
    }
}
