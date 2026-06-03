<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Draft = 'draft';
    case HasDetails = 'has-details';
    case Active = 'active';
    case Inactive = 'inactive';
    case Discontinued = 'discontinued';
}
