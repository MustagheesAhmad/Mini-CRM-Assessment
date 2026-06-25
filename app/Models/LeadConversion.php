<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadConversion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'lead_id',
        'lead_name',
        'converted_by',
        'converted_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'converted_at' => 'datetime',
            'created_at'   => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function convertedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_by');
    }
}
