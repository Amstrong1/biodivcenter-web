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
            $table->id();
            $table->foreignId('specie_id')->constrained()->onDelete('cascade');
            $table->foreignId('ong_id')->constrained()->onDelete('cascade');
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->foreignId('pen_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('weight');
            $table->string('height');
            $table->string('sex');
            $table->date('birthdate');
            $table->string('description');
            $table->string('photo')->nullable();
            $table->string('state')->default('present');
            $table->string('origin')->nullable();
            $table->foreignId('animal_id')->nullable()->references('id')->on('animals');
            $table->string('slug');
            $table->timestamps();
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
