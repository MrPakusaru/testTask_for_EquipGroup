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
        Schema::dropIfExists('prices');
        Schema::create('prices', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');

            $table->id()->startingValue(183);
            $table->foreignId('id_product')->nullable(false)
                ->constrained('products')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('price', 10, 2)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
