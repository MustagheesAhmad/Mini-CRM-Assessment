<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'assigned_to',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class)->orderBy('created_at');
    }

    public function conversion(): HasOne
    {
        return $this->hasOne(LeadConversion::class);
    }

    public function scopeFilterByStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeFilterByAssignee(Builder $query, ?int $userId): Builder
    {
        return $userId ? $query->where('assigned_to', $userId) : $query;
    }

    public function isConverted(): bool
    {
        return $this->status === LeadStatus::Converted;
    }
}
