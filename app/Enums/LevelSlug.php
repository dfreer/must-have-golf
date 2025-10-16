<?php

namespace App\Enums;

use App\Enums\Traits\EnumTrait;

enum LevelSlug: string
{
    use EnumTrait;

    case BEGINNER = 'beginner';
    case HIGH_HANDICAP = 'high-handicap';
    case MID_HANDICAP = 'mid-handicap';
    case LOW_HANDICAP = 'low-handicap';
    case SCRATCH = 'scratch';
    case PRO = 'pro';
}
