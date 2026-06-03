<?php

namespace App\Jobs;

use App\Ai\Agents\ProductScraperAgent;
use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class CreateProduct implements ShouldQueue
{
    use Queueable;

    // public int $tries = 3;

    // php artisan tinker --execute 'App\Jobs\CreateProduct::dispatch("Bushnell Golf Launch Pro", "https://www.bushnellgolf.com/products/launch-monitors/launch-pro/");'

    public function __construct(
        public readonly string $name,
        public readonly string $url,
    ) {}

    public function handle(): void
    {
        $product = Product::create([
            'name' => $this->name,
        ]);

        $html = Http::get($this->url)->body();

        $response = (new ProductScraperAgent)->prompt(
            "Product name: {$this->name}\n\nPage HTML:\n{$html}"
        );

        $images = $response['image_urls'] ?? null;
        if ($images) {
            foreach ($images as $url) {
                $product->images()->create(['url' => $url]);
            }
        }

        $product->update([
            'description' => $response['description'] ?? null,
            'release_date' => $response['release_date'] ?? now(),
            'sku' => $response['sku'] ?? null,
            'status' => ProductStatus::HasDetails,
        ]);
    }
}
