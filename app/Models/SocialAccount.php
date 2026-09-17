<?php

namespace App\Models;

use App\Enums\SocialiteProvidersEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['provider', 'provider_id'])]
#[Hidden(['provider_id'])]
class SocialAccount extends BaseModel
{
    protected function casts(): array
    {
        return [
            'provider' => SocialiteProvidersEnum::class,
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
