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
        Schema::create('dietaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_id')->constrained();
            $table->dateTime('time');
            $table->integer('staple')->default(0);
            $table->integer('meat')->default(0);
            $table->integer('fruit')->default(0);
            $table->integer('vegetable')->default(0);
            $table->integer('fat')->default(0);
            $table->string('description')->nullable();
            $table->string('img_url_1')->nullable();
            $table->string('img_url_2')->nullable();
            $table->string('img_url_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dietaries');
    }
};
