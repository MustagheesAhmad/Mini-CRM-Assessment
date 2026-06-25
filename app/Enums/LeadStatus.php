<?php

namespace App\Enums;

enum LeadStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Converted = 'converted';

    public function label(): string
    {
        return match($this) {
            LeadStatus::New       => 'New',
            LeadStatus::Contacted => 'Contacted',
            LeadStatus::Converted => 'Converted',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
