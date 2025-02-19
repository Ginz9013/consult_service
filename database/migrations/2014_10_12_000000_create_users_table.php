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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->unique();
            $table->string('nickname')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->float('weight', 4, 1)->nullable();
            $table->float('body_fat', 3, 2)->nullable();
            $table->string('avatar_pic')->nullable();
            $table->dateTime('next_consultation')->nullable();
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
