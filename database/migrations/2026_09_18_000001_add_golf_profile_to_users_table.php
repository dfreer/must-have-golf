<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('dexterity')->nullable()->after('email');
            $table->decimal('handicap', 4, 1)->nullable()->after('dexterity');
            $table->string('experience')->nullable()->after('handicap');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['dexterity', 'handicap', 'experience']);
        });
    }
};
