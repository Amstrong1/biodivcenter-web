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
        Schema::create('sites', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('ong_id');
            $table->ulid('type_habitat_id');
            $table->string('name')->unique();
            $table->string('address');
            $table->string('tracking')->nullable();
            $table->string('area');
            $table->string('type')->default('Mixte');
            $table->string('main_goal');
            $table->string('second_goal')->nullable();
            $table->string('photo')->nullable();
            $table->string('logo')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');
            $table->foreign('type_habitat_id')->references('id')->on('type_habitats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
