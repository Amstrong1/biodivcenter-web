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
        Schema::create('ong_agreements', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('ong_id');
            $table->string('agreement');
            $table->string('detail')->nullable();
            $table->string('num_agreement')->nullable();
            $table->string('obtainment_date');
            $table->string('expiration_date')->nullable();
            $table->timestamps();

            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ong_agreements');
    }
};
