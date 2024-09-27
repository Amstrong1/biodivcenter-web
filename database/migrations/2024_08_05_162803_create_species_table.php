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
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('order_id')->constrained();
            // $table->foreignId('classification_id')->constrained();
            // $table->foreignId('family_id')->constrained();
            // $table->foreignId('genus_id')->constrained();
            // $table->foreignId('reign_id')->constrained();
            // $table->foreignId('branch_id')->constrained();
            $table->string('status_uicn')->nullable();
            $table->string('status_cites')->nullable();
            $table->string('scientific_name');
            $table->string('french_name');
            // $table->string('english_name')->nullable();
            $table->string('uicn_link')->nullable();
            $table->string('inaturalist_link')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
