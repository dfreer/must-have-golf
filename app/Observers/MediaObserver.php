<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Observers\MediaObserver as SpatieMediaObserver;

class MediaObserver extends SpatieMediaObserver
{
    public function creating(Media $media): void
    {
        parent::creating($media);
        if ($media instanceof \App\Models\Media) {
            $media->user()->associate(Auth::user());
        }
    }
}
