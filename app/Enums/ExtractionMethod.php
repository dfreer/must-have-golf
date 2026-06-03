<?php

namespace App\Enums;

enum ExtractionMethod: string
{
    case Ai = 'ai';
    case Manual = 'manual';
    case Hybrid = 'hybrid';
}
