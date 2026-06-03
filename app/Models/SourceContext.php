<?php

namespace App\Models;

use App\Enums\SourceContextType;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'type', 'score', 'score_override'])]
class SourceContext extends BaseModel
{
    protected $casts = [
        'type' => SourceContextType::class,
    ];

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function productScores()
    {
        return $this->hasMany(ProductScore::class);
    }
}
