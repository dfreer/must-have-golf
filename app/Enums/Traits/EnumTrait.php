<?php

namespace App\Enums\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait EnumTrait
{
    public static function map(): Collection
    {
        return collect(self::cases())
            ->map(function ($case) {
                $hasLabelMethod = method_exists(__CLASS__, 'label');
                return ['value' => $case->value, 'label' => $hasLabelMethod ? $case->label() : Str::headline($case->name)];
            });
    }

    public function slug(): string
    {
        return $this->value;
    }

    public function label(): string
    {
        return Str::headline($this->value);
    }
}
