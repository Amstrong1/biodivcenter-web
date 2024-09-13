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
        Schema::create('alimentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('ong_id')->constrained();
            $table->foreignId('site_id')->constrained();
            $table->foreignId('specie_id')->constrained();
            $table->string('age_range');
            $table->string('food');
            $table->string('frequency');
            $table->integer('quantity');
            $table->decimal('cost', 10, 2);
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentations');
    }
};
