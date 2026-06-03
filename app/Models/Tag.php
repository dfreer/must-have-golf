<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Spatie\Sluggable\Attributes\Sluggable;

#[Fillable(['name', 'type'])]
#[Sluggable(from: 'name', to: 'slug')]
class Tag extends BaseModel
{
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'taggable');
    }
}
