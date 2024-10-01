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
        Schema::create('animals', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('specie_id');
            $table->ulid('ong_id');
            $table->ulid('site_id');
            $table->ulid('pen_id');
            $table->string('name');
            $table->string('weight');
            $table->string('height');
            $table->string('sex');
            $table->date('birthdate');
            $table->string('description');
            $table->string('photo')->nullable();
            $table->string('state')->default('present');
            $table->string('origin')->nullable();
            $table->ulid('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('specie_id')->references('id')->on('species')->onDelete('cascade');
            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('pen_id')->references('id')->on('pens')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('animals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
