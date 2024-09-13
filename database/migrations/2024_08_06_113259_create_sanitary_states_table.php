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
        Schema::create('sanitary_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ong_id')->constrained();
            $table->foreignId('site_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('animal_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('description');
            $table->string('corrective_action')->nullable();
            $table->numeric('cost', 10, 2)->default(0);
            $table->integer('temperature')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanitary_states');
    }
};
