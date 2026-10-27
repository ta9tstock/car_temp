<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temp_settings', function (Blueprint $table) {
            $table->id('temp_settings_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('MAX_temp');
            $table->integer('MIN_temp');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_settings');
    }
};