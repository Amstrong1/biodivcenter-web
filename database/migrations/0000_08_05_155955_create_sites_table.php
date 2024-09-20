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
            $table->id();
            $table->foreignId('ong_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_habitat_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('tracking')->nullable()->change();
            $table->string('area');
            $table->string('type')->default('Mixte');
            $table->string('main_goal');
            $table->string('second_goal')->nullable();
            $table->string('photo')->nullable();
            $table->string('logo')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
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
