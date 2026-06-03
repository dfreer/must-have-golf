<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['score', 'score_override'])]
class ProductScore extends BaseModel
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(ProductReview::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function sourceContext(): BelongsTo
    {
        return $this->belongsTo(SourceContext::class);
    }
}
