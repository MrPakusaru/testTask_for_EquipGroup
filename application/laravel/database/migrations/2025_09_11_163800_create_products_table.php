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
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');

            $table->id()->startingValue(83);
            $table->foreignId('id_group')->default(0)->nullable(false)
                ->constrained('groups')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 250)->charset('utf8mb3')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
