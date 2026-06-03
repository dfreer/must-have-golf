<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'description', 'score', 'status', 'release_date'])]
class Product extends BaseModel
{
    protected $casts = [
        'status' => ProductStatus::class,
        'release_date' => 'date',
    ];

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function scores()
    {
        return $this->hasMany(ProductScore::class);
    }

    public function links()
    {
        return $this->hasMany(ProductLink::class);
    }
}
