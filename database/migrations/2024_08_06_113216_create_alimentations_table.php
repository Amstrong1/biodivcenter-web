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
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->ulid('ong_id');
            $table->ulid('site_id');
            $table->ulid('specie_id');
            $table->string('age_range');
            $table->string('food');
            $table->string('frequency');
            $table->integer('quantity');
            $table->decimal('cost', 10, 2);
            $table->timestamps();

            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('specie_id')->references('id')->on('species')->onDelete('cascade');
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
