<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'website'])]
class Manufacturer extends BaseModel
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'name' => 'string',
            'slug' => 'string',
            'website' => 'string',
        ];
    }
}
