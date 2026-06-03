<?php

namespace App\Actions;

use App\Models\Product;
use App\Services\MhgScoreCalculator;

class RecalculateProductScore
{
    public function __construct(private readonly MhgScoreCalculator $calculator) {}

    public function handle(Product $product): void
    {
        $score = $this->calculator->calculate($product);

        $product->score = $score;
        $product->saveQuietly();
    }
}
