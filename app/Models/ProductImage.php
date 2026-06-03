<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['url'])]
class ProductImage extends BaseModel
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
