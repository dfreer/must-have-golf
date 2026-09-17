<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

#[Fillable(['collection_name', 'name', 'file_name', 'mime_type', 'disk', 'conversions_disk', 'size', 'manipulations', 'custom_properties', 'generated_conversions', 'responsive_images', 'order_column'])]
#[Hidden(['model_type', 'model_id'])]
class Media extends SpatieMedia
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory, HasUlids;

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
