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
        Schema::create('pens', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('ong_id')->constrained()->onDelete('cascade');
            $table->ulid('site_id')->constrained()->onDelete('cascade');
            $table->string('number');
            $table->string('description');
            $table->string('area');
            $table->string('photo')->nullable();
            $table->string('state')->default('Disponible');
            $table->timestamps();

            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pens');
    }
};
