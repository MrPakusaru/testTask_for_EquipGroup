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
        Schema::dropIfExists('groups');
        Schema::create('groups', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');

            $table->id()->startingValue(35);
            $table->integer('id_parent')->nullable(false);
            $table->string('name', 100)->charset('utf8mb3')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
