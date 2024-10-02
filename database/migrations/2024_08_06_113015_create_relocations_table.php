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
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->ulid('animal_id');
            $table->ulid('ong_origin_id');
            $table->ulid('ong_destination_id');
            $table->ulid('site_origin_id');
            $table->ulid('site_destination_id');
            $table->string('comment');
            $table->date('date_transfert');
            $table->timestamps();

            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            $table->foreign('ong_origin_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('ong_destination_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('site_origin_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('site_destination_id')->references('id')->on('sites')->onDelete('cascade');
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
