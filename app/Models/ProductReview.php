<?php

namespace App\Models;

use App\Enums\ProductReviewStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['status'])]
class ProductReview extends BaseModel
{
    protected $casts = [
        'status' => ProductReviewStatus::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scores()
    {
        return $this->hasMany(ProductScore::class);
    }
}
