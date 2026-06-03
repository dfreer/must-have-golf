<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductScore;

class MhgScoreCalculator
{
    /**
     * Calculate the MHG Score for a product as a weighted average of all its ProductScore records.
     *
     * Each ProductScore is weighted by its source trust weight × source context trust weight.
     * Only scores where both the Source and SourceContext have a confirmed (non-null) trust weight
     * are included in the calculation.
     *
     * Returns null when there are no qualifying scores.
     */
    public function calculate(Product $product): ?float
    {
        $scores = $product->scores()
            ->with(['source', 'sourceContext'])
            ->get();

        $weightedSum = 0.0;
        $totalWeight = 0.0;

        foreach ($scores as $productScore) {
            /** @var ProductScore $productScore */
            $sourceWeight = $productScore->source?->score_override ?? $productScore->source?->score;
            $contextWeight = $productScore->sourceContext?->score_override ?? $productScore->sourceContext?->score;

            if ($sourceWeight === null || $contextWeight === null) {
                continue;
            }

            $combinedWeight = $sourceWeight * $contextWeight;

            if ($combinedWeight <= 0) {
                continue;
            }

            $rawScore = $productScore->score_override ?? $productScore->score;

            $weightedSum += $rawScore * $combinedWeight;
            $totalWeight += $combinedWeight;
        }

        if ($totalWeight === 0.0) {
            return null;
        }

        return round($weightedSum / $totalWeight, 2);
    }
}
