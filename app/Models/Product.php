<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable(['name', 'sku', 'description', 'score', 'status', 'release_date'])]
class Product extends BaseModel
{
    use HasSlug;

    protected $casts = [
        'status' => ProductStatus::class,
        'release_date' => 'date',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function (Product $product): string {
                $parts = [$product->name];

                if ($product->release_date) {
                    $parts[] = $product->release_date->format('Y');
                }

                return implode(' ', $parts);
            })
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
