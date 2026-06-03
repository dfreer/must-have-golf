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
        Schema::create('source_contexts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->decimal('score', 4, 2)->nullable();
            $table->decimal('score_override', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_contexts');
    }
};
