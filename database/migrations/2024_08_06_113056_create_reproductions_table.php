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
        Schema::create('reproductions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('ong_id');
            $table->ulid('site_id');
            $table->foreignId('user_id')->constrained();
            $table->ulid('animal_id');
            $table->string('phase');
            $table->integer('litter_size');
            $table->date('date');
            $table->string('observation')->nullable();
            $table->timestamps();

            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reproductions');
    }
};
