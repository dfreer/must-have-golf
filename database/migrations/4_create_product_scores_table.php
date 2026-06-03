<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_scores', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('product_id')->constrained('products');
            $table->foreignUlid('review_id')->constrained('product_reviews');
            $table->foreignUlid('source_id')->constrained('sources');
            $table->foreignUlid('source_context_id')->constrained('source_contexts');
            $table->decimal('score', 4, 2);
            $table->decimal('score_override', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_scores');
    }
};
