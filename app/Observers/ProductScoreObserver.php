<?php

namespace App\Observers;

use App\Actions\RecalculateProductScore;
use App\Models\ProductScore;

class ProductScoreObserver
{
    public function __construct(private readonly RecalculateProductScore $action) {}

    public function created(ProductScore $productScore): void
    {
        $this->recalculate($productScore);
    }

    public function updated(ProductScore $productScore): void
    {
        $this->recalculate($productScore);
    }

    public function deleted(ProductScore $productScore): void
    {
        $this->recalculate($productScore);
    }

    private function recalculate(ProductScore $productScore): void
    {
        if ($productScore->product) {
            $this->action->handle($productScore->product);
        }
    }
}
