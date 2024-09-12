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
        Schema::create('relocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('animal_id')->constrained();
            $table->foreignId('ong_origin_id')->constrained('ongs');
            $table->foreignId('ong_destination_id')->constrained('ongs');
            $table->foreignId('site_origin_id')->constrained('sites');
            $table->foreignId('site_destination_id')->constrained('sites');
            $table->foreignId('pen_origin_id')->constrained('pens')->nullable();
            $table->foreignId('pen_destination_id')->constrained('pens')->nullable();
            $table->string('comment')->nullable();
            $table->date('date_transfert');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relocations');
    }
};
