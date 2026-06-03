<?php

namespace App\Enums;

enum ProductReviewStatus: string
{
    case Pending = 'pending';
    case Done = 'done';
    case Failed = 'failed';
}
