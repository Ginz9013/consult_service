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
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_id')->constrained();
            $table->time('time');
            $table->float('staple', 3, 1)->default(0);
            $table->float('meat', 3, 1)->default(0);
            $table->float('fruit', 3, 1)->default(0);
            $table->float('vegetable', 3, 1)->default(0);
            $table->float('fat', 3, 1)->default(0);
            $table->string('description', 1000)->nullable();
            $table->string('img_url_1', 2083)->nullable();
            $table->string('img_url_2', 2083)->nullable();
            $table->string('img_url_3', 2083)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
