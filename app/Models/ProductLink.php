<?php

namespace App\Models;

use App\Enums\Affiliate;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['affiliate', 'url'])]
class ProductLink extends BaseModel
{
    protected $casts = [
        'affiliate' => Affiliate::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
