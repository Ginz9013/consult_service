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
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('date')->unique();
            $table->float('weight', 4, 1)->nullable();
            $table->float('body_fat', 3, 2)->nullable();
            $table->integer('water_morning')->nullable();
            $table->integer('water_afternoon')->nullable();
            $table->integer('water_evening')->nullable();
            $table->integer('water_another')->nullable();
            $table->integer('coffee')->nullable();
            $table->integer('tea')->nullable();
            $table->string('sport', 1000)->nullable();
            $table->string('defecation', 1000)->nullable();
            $table->string('note', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dailies');
    }
};
