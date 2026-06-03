<?php

use App\Models\Product;
use App\Models\ProductScore;
use App\Models\Source;
use App\Models\SourceContext;
use App\Services\MhgScoreCalculator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

function makeProductWithScores(array $scoreData): Product
{
    $scores = collect($scoreData)->map(function (array $data): ProductScore {
        $context = new SourceContext;
        $context->score = $data['context_score'] ?? null;
        $context->score_override = $data['context_score_override'] ?? null;

        $source = new Source;
        $source->score = $data['source_score'] ?? null;
        $source->score_override = $data['source_score_override'] ?? null;

        $productScore = new ProductScore;
        $productScore->score = $data['score'];
        $productScore->score_override = $data['score_override'] ?? null;
        $productScore->setRelation('source', $source);
        $productScore->setRelation('sourceContext', $context);

        return $productScore;
    });

    $relation = Mockery::mock(HasMany::class);
    $relation->shouldReceive('with')->with(['source', 'sourceContext'])->andReturnSelf();
    $relation->shouldReceive('get')->andReturn(new Collection($scores->all()));

    $product = Mockery::mock(Product::class)->makePartial();
    $product->shouldReceive('scores')->andReturn($relation);

    return $product;
}

test('returns null when there are no product scores', function (): void {
    $product = makeProductWithScores([]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBeNull();
});

test('returns null when all sources have unconfirmed trust weights', function (): void {
    $product = makeProductWithScores([
        ['score' => 8.0, 'source_score' => null, 'context_score' => 0.8],
        ['score' => 7.0, 'source_score' => 0.9, 'context_score' => null],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBeNull();
});

test('calculates a simple weighted average for a single score', function (): void {
    $product = makeProductWithScores([
        ['score' => 8.0, 'source_score' => 1.0, 'context_score' => 1.0],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(8.0);
});

test('uses score_override on product score when set', function (): void {
    $product = makeProductWithScores([
        ['score' => 5.0, 'score_override' => 9.0, 'source_score' => 1.0, 'context_score' => 1.0],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(9.0);
});

test('uses score_override on source when set', function (): void {
    // source_score = 0.5, source_score_override = 1.0
    // weighted = 8.0 * 1.0 * 0.8 = 6.4; total_weight = 0.8 → result = 8.0
    $product = makeProductWithScores([
        ['score' => 8.0, 'source_score' => 0.5, 'source_score_override' => 1.0, 'context_score' => 0.8],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(8.0);
});

test('uses score_override on source context when set', function (): void {
    // context_score = 0.5, context_score_override = 1.0
    // weighted = 8.0 * 0.8 * 1.0 = 6.4; total_weight = 0.8 → result = 8.0
    $product = makeProductWithScores([
        ['score' => 8.0, 'source_score' => 0.8, 'context_score' => 0.5, 'context_score_override' => 1.0],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(8.0);
});

test('calculates weighted average across multiple scores', function (): void {
    // score A: raw=10, w_s=1.0, w_sc=1.0 → weighted=10, weight=1.0
    // score B: raw=6,  w_s=0.5, w_sc=1.0 → weighted=3,  weight=0.5
    // result = (10 + 3) / (1.0 + 0.5) = 13 / 1.5 = 8.67
    $product = makeProductWithScores([
        ['score' => 10.0, 'source_score' => 1.0, 'context_score' => 1.0],
        ['score' => 6.0,  'source_score' => 0.5, 'context_score' => 1.0],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(8.67);
});

test('skips scores with zero combined weight', function (): void {
    $product = makeProductWithScores([
        ['score' => 10.0, 'source_score' => 0.0, 'context_score' => 1.0],
        ['score' => 6.0,  'source_score' => 1.0, 'context_score' => 1.0],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(6.0);
});

test('excludes unconfirmed sources and scores confirmed ones', function (): void {
    // score A: no source trust weight — excluded
    // score B: raw=8, w_s=0.9, w_sc=1.0 — included → result = 8.0
    $product = makeProductWithScores([
        ['score' => 10.0, 'source_score' => null, 'context_score' => 1.0],
        ['score' => 8.0,  'source_score' => 0.9,  'context_score' => 1.0],
    ]);

    $result = (new MhgScoreCalculator)->calculate($product);

    expect($result)->toBe(8.0);
});
