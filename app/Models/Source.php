<?php

namespace App\Models;

use App\Enums\SourceType;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'type', 'url', 'score', 'score_override'])]
class Source extends BaseModel
{
    protected $casts = [
        'type' => SourceType::class,
    ];

    public function sourceContext()
    {
        return $this->belongsTo(SourceContext::class);
    }

    public function productScores()
    {
        return $this->hasMany(ProductScore::class);
    }
}
